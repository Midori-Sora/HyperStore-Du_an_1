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
                'returned' => 'Đã trả hàng',
                'refunded' => 'Đã hoàn tiền'
            ],
            'delivered' => [
                'returned' => 'Đã trả hàng',
                'refunded' => 'Đã hoàn tiền',
                'failed' => 'Thất bại'
            ],
            'cancelled' => [
                'failed' => 'Thất bại'
            ],
            'returned' => [
                'refunded' => 'Đã hoàn tiền'
            ],
            'refunded' => [
                'returned' => 'Đã trả hàng',
                'failed' => 'Thất bại'
            ],
            'failed' => [
                'cancelled' => 'Đã hủy',
                'awaiting_payment' => 'Chờ thanh toán'
            ],
            'awaiting_payment' => [
                'confirmed' => 'Đã xác nhận',
                'failed' => 'Thất bại'
            ]
        ];

        return $transitions[$currentStatus] ?? [];
    }
}
