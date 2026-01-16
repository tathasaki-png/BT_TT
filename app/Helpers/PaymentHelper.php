<?php

namespace App\Helpers;

use App\Services\VNPayService;

class PaymentHelper
{
    protected static $vnpayService = null;

    /**
     * Lấy instance VNPayService
     */
    public static function vnpay()
    {
        if (self::$vnpayService === null) {
            self::$vnpayService = app(VNPayService::class);
        }
        return self::$vnpayService;
    }

    /**
     * Kiểm tra xem order có thể thanh toán được không
     */
    public static function canPayOrder($order)
    {
        return $order->payment_status === 'pending' && $order->payment_method === 'vnpay';
    }

    /**
     * Kiểm tra xem order có thể hoàn tiền được không
     */
    public static function canRefundOrder($order)
    {
        return $order->payment_status === 'completed' 
            && !in_array($order->status, ['shipped', 'delivered', 'cancelled', 'refunded']);
    }

    /**
     * Format tiền VNPay (nhân 100)
     */
    public static function formatAmount($amount)
    {
        return (int)($amount * 100);
    }

    /**
     * Lấy nhãn trạng thái thanh toán
     */
    public static function getPaymentStatusLabel($status)
    {
        $labels = [
            'pending' => 'Chưa thanh toán',
            'completed' => 'Đã thanh toán',
            'failed' => 'Thanh toán thất bại',
            'refunded' => 'Đã hoàn tiền',
        ];

        return $labels[$status] ?? $status;
    }

    /**
     * Lấy màu badge cho trạng thái thanh toán
     */
    public static function getPaymentStatusBadgeClass($status)
    {
        $classes = [
            'pending' => 'bg-warning',
            'completed' => 'bg-success',
            'failed' => 'bg-danger',
            'refunded' => 'bg-secondary',
        ];

        return $classes[$status] ?? 'bg-secondary';
    }

    /**
     * Lấy nhãn phương thức thanh toán
     */
    public static function getPaymentMethodLabel($method)
    {
        $labels = [
            'direct' => 'Thanh toán khi nhận hàng',
            'vnpay' => 'VNPay',
        ];

        return $labels[$method] ?? $method;
    }
}
