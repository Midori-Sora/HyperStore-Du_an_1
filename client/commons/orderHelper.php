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
            'return_requested' => 'Yêu cầu trả hàng',
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
            'return_requested' => 'status-warning',
            'returned' => 'status-returned',
            'refunded' => 'status-refunded',
            'failed' => 'status-failed'
        ];

        return $classMap[$status] ?? 'status-pending';
    }

    public static function getAllowedStatusTransitions($currentStatus)
    {
        $transitions = [
            'pending' => [
                'confirmed' => 'Đã xác nhận',
                'cancelled' => 'Đã hủy',
                'failed' => 'Thất bại'
            ],
            'confirmed' => [
                'processing' => 'Đang chuẩn bị hàng',
                'cancelled' => 'Đã hủy',
                'failed' => 'Thất bại'
            ],
            'processing' => [
                'shipping' => 'Đang giao hàng',
                'cancelled' => 'Đã hủy',
                'failed' => 'Thất bại'
            ],
            'shipping' => [
                'delivered' => 'Giao thành công',
                'failed' => 'Thất bại'
            ],
            'delivered' => [
                'return_requested' => 'Yêu cầu trả hàng',
                'failed' => 'Thất bại'
            ],
            'return_requested' => [
                'returned' => 'Chấp nhận trả hàng',
                'delivered' => 'Từ chối trả hàng'
            ],
            'returned' => [
                'refunded' => 'Đã hoàn tiền'
            ],
            'cancelled' => [
                'failed' => 'Thất bại'
            ],
            'refunded' => [
                'failed' => 'Thất bại'
            ],
            'failed' => [
                'cancelled' => 'Đã hủy'
            ]
        ];

        return $transitions[$currentStatus] ?? [];
    }

    public static function canCancelOrder($status)
    {
        return in_array($status, ['pending', 'confirmed', 'processing']);
    }

    public static function canRequestReturn($status)
    {
        return $status === 'delivered';
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
