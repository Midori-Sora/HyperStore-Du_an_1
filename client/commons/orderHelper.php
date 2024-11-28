<?php
class OrderHelper
{
    public static function getOrderStatus($status)
    {
        $statusMap = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang chuẩn bị hàng',
            'shipping' => 'Đang giao hàng', 
            'delivered' => 'Đã giao thành công',
            'cancelled' => 'Đã hủy',
            'returned' => 'Đã trả hàng',
            'refunded' => 'Đã hoàn tiền',
            'failed' => 'Giao hàng thất bại'
        ];

        return $statusMap[$status] ?? 'Không xác định';
    }

    public static function getOrderStatusClass($status)
    {
        $classMap = [
            'pending' => 'status-pending',
            'confirmed' => 'status-confirmed',
            'processing' => 'status-processing',
            'shipping' => 'status-shipping',
            'delivered' => 'status-delivered',
            'cancelled' => 'status-cancelled',
            'returned' => 'status-returned',
            'refunded' => 'status-refunded',
            'failed' => 'status-failed'
        ];

        return $classMap[$status] ?? 'status-pending';
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
