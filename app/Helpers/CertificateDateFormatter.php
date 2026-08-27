<?php

namespace App\Helpers;

class CertificateDateFormatter
{
    private static $bn_numbers = [
        '0' => '০',
        '1' => '১',
        '2' => '২',
        '3' => '৩',
        '4' => '৪',
        '5' => '৫',
        '6' => '৬',
        '7' => '৭',
        '8' => '৮',
        '9' => '৯'
    ];

    public static function format($date)
    {
        if (!$date) return '';

        if (!is_numeric($date)) {
            $date = strtotime($date);
        }

        $year = date('Y', $date);
        $month = date('m', $date);
        $day = date('d', $date);

        $formatted = self::convertToBangla($year) . '-' . 
                    self::convertToBangla($month) . '-' . 
                    self::convertToBangla($day);

        return ': ' . $formatted;
    }

    private static function convertToBangla($number)
    {
        $number = (string)$number;
        $output = '';
        
        for ($i = 0; $i < strlen($number); $i++) {
            $output .= self::$bn_numbers[$number[$i]] ?? $number[$i];
        }
        
        return $output;
    }
}