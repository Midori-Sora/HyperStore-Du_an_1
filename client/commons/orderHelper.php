<?php
class OrderHelper
{
    const RETURN_PERIOD_DAYS = 7; // 7 ngày

    public static function getOrderStatus($status)
    {
        $statusMap = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang chuẩn bị hàng',
            'shipping' => 'Đang giao hàng',
            'delivered' => 'Đã giao thành công',
            'cancelled' => 'Đã hủy',
            'cancel_requested' => 'Yêu cầu hủy',
            'return_requested' => 'Yêu cầu trả hàng',
            'returned' => 'Đã trả hàng',
            'return_failed' => 'Từ chối trả hàng'
        ];

        return isset($statusMap[$status]) ? $statusMap[$status] : 'Không xác định';
    }

    public static function getOrderStatusClass($status)
    {
        $classMap = [
            'pending' => 'pending',
            'confirmed' => 'confirmed',
            'processing' => 'processing',
            'shipping' => 'shipping',
            'delivered' => 'delivered',
            'cancelled' => 'cancelled',
            'return_requested' => 'return-requested',
            'returned' => 'returned',
            'return_failed' => 'return-failed',
            'refunded' => 'refunded',
            'failed' => 'failed'
        ];

        return isset($classMap[$status]) ? $classMap[$status] : 'unknown';
    }

    public static function getAllowedStatusTransitions($currentStatus)
    {
        $transitions = [
            'pending' => [
                'confirmed' => 'Đã xác nhận',
                'cancelled' => 'Đã hủy'
            ],
            'confirmed' => [
                'processing' => 'Đang xử lý',
                'cancelled' => 'Đã hủy'
            ],
            'processing' => [
                'shipping' => 'Đang giao hàng',
                'cancelled' => 'Đã hủy'
            ],
            'shipping' => [
                'delivered' => 'Đã giao hàng',
                'cancelled' => 'Đã hủy'
            ],
            'delivered' => [
                'return_requested' => 'Yêu cầu trả hàng'
            ],
            'return_requested' => [
                'returned' => 'Đã trả hàng',
                'delivered' => 'Từ chối trả hàng'
            ],
            'returned' => [],
            'cancelled' => []
        ];

        return $transitions[$currentStatus] ?? [];
    }

    public static function canCancelOrder($status)
    {
        return in_array($status, ['pending', 'confirmed', 'processing']);
    }

    public static function canRequestReturn($status, $deliveredDate)
    {
        if ($status !== 'delivered') {
            return false;
        }

        $deliveredDateTime = new DateTime($deliveredDate);
        $now = new DateTime();
        $daysSinceDelivery = $now->diff($deliveredDateTime)->days;

        return $daysSinceDelivery <= self::RETURN_PERIOD_DAYS;
    }

    public static function getRemainingReturnDays($deliveredDate)
    {
        $deliveredDateTime = new DateTime($deliveredDate);
        $now = new DateTime();
        $daysSinceDelivery = $now->diff($deliveredDateTime)->days;

        return max(0, self::RETURN_PERIOD_DAYS - $daysSinceDelivery);
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