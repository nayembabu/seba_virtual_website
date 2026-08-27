<?php

namespace App\Helpers;

class NotificationHelper
{
    public static function success($message)
    {
        return [
            'success' => $message,
            'alert-type' => 'success'
        ];
    }

    public static function error($message)
    {
        return [
            'error' => $message,
            'alert-type' => 'error'
        ];
    }

    public static function warning($message)
    {
        return [
            'warning' => $message,
            'alert-type' => 'warning'
        ];
    }

    public static function info($message)
    {
        return [
            'info' => $message,
            'alert-type' => 'info'
        ];
    }

    public static function insufficientBalance($required, $current)
    {
        $message = sprintf(
            'অপর্যাপ্ত ব্যালেন্স। প্রয়োজনীয় পরিমাণ: %s টাকা, বর্তমান ব্যালেন্স: %s টাকা',
            number_format($required, 2),
            number_format($current, 2)
        );

        return [
            'error' => $message,
            'alert-type' => 'error'
        ];
    }
}