<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderItem;

class RevokeCancelledOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:revoke-cancelled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detach course enrollments for users whose orders were cancelled (skips courses with other completed purchases).';

    public function handle()
    {
        $this->info('Scanning cancelled orders...');

        $orders = Order::where('status', 'cancelled')->with(['items', 'user'])->get();
        $totalDetached = 0;
        $skipped = 0;

        foreach ($orders as $order) {
            $user = $order->user;
            if (!$user) continue;

            foreach ($order->items as $item) {
                $courseId = $item->course_id;

                // If user has another completed order that contains this course, skip detaching
                $hasOtherCompleted = OrderItem::where('course_id', $courseId)
                    ->whereHas('order', function ($q) use ($user) {
                        $q->where('user_id', $user->id)->where('status', 'completed');
                    })->exists();

                if ($hasOtherCompleted) {
                    $skipped++;
                    continue;
                }

                // Detach this course from user
                $detached = $user->courses()->detach($courseId);
                if ($detached) $totalDetached++;
            }
        }

        $this->info("Done. Detached: {$totalDetached}. Skipped (other completed purchases): {$skipped}.");
        return 0;
    }
}
