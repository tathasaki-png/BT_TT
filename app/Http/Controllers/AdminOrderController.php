<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderCompletedNotification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        $order->load(['user', 'items.course.instructor']);
        
        if ($request->ajax() || $request->wantsJson()) {
            return view('admin.orders.partials.details', compact('order'));
        }
        
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:awaiting,pending,shipping,delivered,completed,cancelled',
        ]);

        $previous = $order->status;
        $order->status = $request->status;
        $order->save();

        // Statuses that grant access to courses
        $approvedStatuses = ['delivered', 'completed'];
        $user = $order->user;
        
        if ($user) {
            $courseIds = $order->items->pluck('course_id')->toArray();
            
            // Gain access: New status is approved, previous was NOT
            if (in_array($request->status, $approvedStatuses) && !in_array($previous, $approvedStatuses)) {
                $user->courses()->syncWithoutDetaching($courseIds);
                try {
                    SendOrderCompletedNotification::dispatchSync($order);
                } catch (\Throwable $e) {
                    Log::error("Failed to send order completion email for order #{$order->id}: " . $e->getMessage());
                }
            } 
            // Revoke access in two cases:
            // 1. Status is moved from Approved back to Unapproved (e.g., set 'completed' by mistake, then back to 'pending')
            // 2. Status is explicitly set to 'cancelled'
            elseif (
                (in_array($previous, $approvedStatuses) && !in_array($request->status, $approvedStatuses)) ||
                ($request->status === 'cancelled' && $previous !== 'cancelled')
            ) {
                $user->courses()->detach($courseIds);
            }
        }

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng.');
    }

    public function destroy(Order $order)
    {
        // Items are automatically deleted due to foreign key cascade
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Đã xóa đơn hàng thành công.');
    }
}
