<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRevenueController extends Controller
{
    public function index()
    {
        // Statuses that represent actual revenue
        $revenueStatuses = ['completed', 'delivered'];

        // Tổng doanh thu theo từng phương thức (chỉ tính đơn hoàn thành)
        $revenueByMethod = Order::whereIn('status', $revenueStatuses)
            ->select('payment_method', DB::raw('SUM(total_price) as total'))
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method')
            ->toArray();

        $revenueCOD = $revenueByMethod['cod'] ?? 0;
        $revenueVNPay = $revenueByMethod['vnpay'] ?? 0;
        $totalRevenue = $revenueCOD + $revenueVNPay;

        // Dữ liệu cho biểu đồ: Doanh thu 30 ngày gần đây
        $dailyRevenue = Order::whereIn('status', $revenueStatuses)
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(CASE WHEN payment_method = "cod" THEN total_price ELSE 0 END) as cod_revenue'),
                DB::raw('SUM(CASE WHEN payment_method = "vnpay" THEN total_price ELSE 0 END) as vnpay_revenue'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartData = [
            'labels' => $dailyRevenue->pluck('date')->map(fn($date) => date('d/m', strtotime($date))),
            'cod' => $dailyRevenue->pluck('cod_revenue'),
            'vnpay' => $dailyRevenue->pluck('vnpay_revenue'),
            'total' => $dailyRevenue->pluck('total_revenue'),
        ];

        return view('admin.revenue.index', compact('revenueCOD', 'revenueVNPay', 'totalRevenue', 'chartData'));
    }
}
