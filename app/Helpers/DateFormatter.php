<?php

namespace App\Helpers;

class DateFormatter 
{
    private static $ordinal_suffix = [
        1 => 'st',
        2 => 'nd',
        3 => 'rd',
        21 => 'st',
        22 => 'nd',
        23 => 'rd',
        31 => 'st'
    ];

    private static $bengali_months = [
        1 => 'বৈশাখ',
        2 => 'জ্যৈষ্ঠ',
        3 => 'আষাঢ়',
        4 => 'শ্রাবণ',
        5 => 'ভাদ্র',
        6 => 'আশ্বিন',
        7 => 'কার্তিক',
        8 => 'অগ্রহায়ণ',
        9 => 'পৌষ',
        10 => 'মাঘ',
        11 => 'ফাল্গুন',
        12 => 'চৈত্র'
    ];

    public static function formatDateToWords($date)
    {
        if (!$date) return '';

        // Convert to timestamp if it's not already
        if (!is_numeric($date)) {
            $date = strtotime($date);
        }

        $day = date('j', $date); // Day without leading zeros
        $month = date('F', $date); // Full month name
        $year = date('Y', $date);

        // Get the ordinal suffix for the day
        $suffix = isset(self::$ordinal_suffix[$day]) 
            ? self::$ordinal_suffix[$day] 
            : 'th';

        return $day . $suffix . ' Of ' . $month . ' ' . $year;
    }

    public static function formatWithSuffix($number)
    {
        if (!is_numeric($number)) return $number;

        $suffix = isset(self::$ordinal_suffix[$number]) 
            ? self::$ordinal_suffix[$number] 
            : 'th';

        return $number . $suffix;
    }

    public static function getBengaliMonth($month)
    {
        return self::$bengali_months[$month] ?? '';
    }

    public static function getAllBengaliMonths()
    {
        return self::$bengali_months;
    }
}