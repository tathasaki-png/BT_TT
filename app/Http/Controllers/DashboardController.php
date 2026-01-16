<?php

namespace App\Http\Controllers;

use App\Models\JobLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     */
    public function index()
    {
        $totalJobs = JobLog::count();
        $successCount = JobLog::where('status', 'success')->count();
        $failedCount = JobLog::where('status', 'failed')->count();
        $processingCount = JobLog::where('status', 'processing')->count();
        $pendingCount = JobLog::where('status', 'pending')->count();

        $successRate = $totalJobs > 0 
            ? round(($successCount / $totalJobs) * 100, 2) 
            : 0;

        $recentLogs = JobLog::orderBy('created_at', 'desc')->limit(10)->get();
        $failedLogs = JobLog::where('status', 'failed')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('dashboard', [
            'totalJobs' => $totalJobs,
            'successCount' => $successCount,
            'failedCount' => $failedCount,
            'processingCount' => $processingCount,
            'pendingCount' => $pendingCount,
            'successRate' => $successRate,
            'recentLogs' => $recentLogs,
            'failedLogs' => $failedLogs,
        ]);
    }

    /**
     * Get job statistics (for API).
     */
    public function stats()
    {
        return response()->json([
            'total' => JobLog::count(),
            'success' => JobLog::where('status', 'success')->count(),
            'failed' => JobLog::where('status', 'failed')->count(),
            'processing' => JobLog::where('status', 'processing')->count(),
            'pending' => JobLog::where('status', 'pending')->count(),
        ]);
    }

    /**
     * Clear failed jobs.
     */
    public function clearFailed()
    {
        JobLog::where('status', 'failed')->delete();
        return redirect()->back()->with('success', 'Cleared failed jobs');
    }

    /**
     * Retry failed job.
     */
    public function retryFailed($id)
    {
        $log = JobLog::find($id);
        
        if (!$log || $log->status !== 'failed') {
            return redirect()->back()->with('error', 'Invalid job log');
        }

        $payload = json_decode($log->payload, true);
        
        \App\Jobs\SendWelcomeEmailJob::dispatch(
            $payload['email'],
            $payload['userName']
        );

        $log->update(['status' => 'pending']);

        return redirect()->back()->with('success', 'Job retried');
    }

    /**
     * Delete user and related job logs.
     */
    public function deleteUser($email)
    {
        // Xóa tất cả job logs của user này
        JobLog::where('email', $email)->delete();
        
        // Xóa user
        \App\Models\User::where('email', $email)->delete();

        return redirect()->back()->with('success', 'User and related logs deleted successfully');
    }
}
