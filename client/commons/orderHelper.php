<?php
class OrderHelper
{
    public static function getOrderStatus($status)
    {
        $statusMap = [
            'pending' => 'Đang chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang chuẩn bị hàng',
            'shipping' => 'Đang giao hàng',
            'delivered' => 'Đã giao thành công',
            'cancelled' => 'Đã hủy',
            'returned' => 'Đã trả hàng',
            'refunded' => 'Đã hoàn tiền',
            'failed' => 'Thất bại',
            'awaiting_payment' => 'Chờ thanh toán'
        ];

        return $statusMap[$status] ?? 'Đang chờ xử lý';
    }

    public static function getOrderStatusClass($status)
    {
        $classMap = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'processing' => 'primary',
            'shipping' => 'info',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'returned' => 'secondary',
            'refunded' => 'dark',
            'failed' => 'danger',
            'awaiting_payment' => 'warning'
        ];

        return $classMap[$status] ?? 'warning';
    }

    public static function canCancelOrder($status)
    {
        return in_array($status, ['pending', 'confirmed', 'processing']);
    }

    public static function formatOrderDate($date)
    {
        return date('d/m/Y H:i', strtotime($date));
    }

    public static function formatCurrency($amount)
    {
        return number_format($amount, 0, ',', '.') . 'đ';
    }
}
