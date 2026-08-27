<?php

namespace App\Helpers;

class BanglaDateFormatter
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

    private static $bn_months = [
        '01' => 'জানুয়ারি',
        '02' => 'ফেব্রুয়ারি',
        '03' => 'মার্চ',
        '04' => 'এপ্রিল',
        '05' => 'মে',
        '06' => 'জুন',
        '07' => 'জুলাই',
        '08' => 'আগস্ট',
        '09' => 'সেপ্টেম্বর',
        '10' => 'অক্টোবর',
        '11' => 'নভেম্বর',
        '12' => 'ডিসেম্বর'
    ];

    public static function formatDate($date)
    {
        if (!$date) return '';

        // Convert to timestamp if it's not already
        if (!is_numeric($date)) {
            $date = strtotime($date);
        }

        $day = date('j', $date); // Day without leading zeros
        $month = date('m', $date); // Month with leading zeros
        $year = date('Y', $date);

        // Convert day to Bangla
        $bn_day = self::convertNumbersToBangla($day);
        
        // Get Bangla month name
        $bn_month = self::$bn_months[$month];
        
        // Convert year to Bangla
        $bn_year = self::convertNumbersToBangla($year);

        return "{$bn_day} {$bn_month} {$bn_year}";
    }

    public static function convertNumbersToBangla($number)
    {
        $number = (string)$number;
        $output = '';
        
        for ($i = 0; $i < strlen($number); $i++) {
            $output .= self::$bn_numbers[$number[$i]] ?? $number[$i];
        }
        
        return $output;
    }
}