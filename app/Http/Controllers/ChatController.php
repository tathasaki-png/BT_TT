<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        Log::info('Chat index accessed by user: ' . Auth::id());
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat', compact('users'));
    }

    public function fetchMessages($receiverId)
    {
        Log::info('Fetching messages between ' . Auth::id() . ' and ' . $receiverId);
        return Message::where(function($query) use ($receiverId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $receiverId);
        })->orWhere(function($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', Auth::id());
        })
        ->with('sender', 'receiver')
        ->orderBy('created_at', 'asc')
        ->get();
    }

    public function sendMessage(Request $request)
    {
        Log::info('Sending message from ' . Auth::id() . ' to ' . $request->receiver_id);
        
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        Log::info('Message saved to DB. Broadcasting event...');
        
        broadcast(new MessageSent($message->load('sender')));

        // Export database to SQL file automatically
        $this->exportDatabaseToSql();

        return ['status' => 'Message Sent!', 'message' => $message];
    }

    /**
     * Export SQLite database to SQL file
     */
    private function exportDatabaseToSql()
    {
        try {
            $db_file = database_path('database.sqlite');
            $output_file = database_path('backup.sql');

            if (!file_exists($db_file)) {
                Log::error("Database file not found: $db_file");
                return;
            }

            $pdo = new \PDO('sqlite:' . $db_file);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            // Get all table names
            $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(\PDO::FETCH_COLUMN);
            
            $sql = "-- SQLite Database Backup\n";
            $sql .= "-- Exported: " . date('Y-m-d H:i:s') . "\n\n";
            
            foreach ($tables as $table) {
                // Get CREATE TABLE statement
                $create = $pdo->query("SELECT sql FROM sqlite_master WHERE type='table' AND name='$table'")->fetch(\PDO::FETCH_ASSOC);
                if ($create['sql']) {
                    $sql .= $create['sql'] . ";\n\n";
                }
                
                // Get all data
                $rows = $pdo->query("SELECT * FROM $table")->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                    $cols = implode(', ', array_keys($row));
                    $vals = implode(', ', array_map(function($v) use ($pdo) {
                        return $v === null ? 'NULL' : $pdo->quote($v);
                    }, array_values($row)));
                    $sql .= "INSERT INTO $table ($cols) VALUES ($vals);\n";
                }
                $sql .= "\n";
            }
            
            file_put_contents($output_file, $sql);
            Log::info('Database exported to backup.sql (' . filesize($output_file) . ' bytes)');
            
        } catch (\Exception $e) {
            Log::error('Failed to export database: ' . $e->getMessage());
        }
    }
}
