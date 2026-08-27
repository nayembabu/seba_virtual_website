<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateToWordsHelper
{
    private static $days = [
        'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth',
        'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth',
        'Eighteenth', 'Nineteenth', 'Twentieth', 'Twenty-first', 'Twenty-second', 'Twenty-third',
        'Twenty-fourth', 'Twenty-fifth', 'Twenty-sixth', 'Twenty-seventh', 'Twenty-eighth',
        'Twenty-ninth', 'Thirtieth', 'Thirty-first'
    ];

    private static $months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    public static function convertDate($date)
    {
        if (!$date) {
            return null;
        }

        $date = Carbon::parse($date);

        return [
            'day_month' => self::$days[$date->day - 1] . ' ' . self::$months[$date->month - 1],
            'year' => self::numberToWords($date->year)
        ];
    }

    public static function numberToWords($num)
    {
        $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        $teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];

        if ($num < 10) return $ones[$num];
        if ($num < 20) return $teens[$num - 10];
        if ($num < 100) return $tens[floor($num/10)] . ($num % 10 ? ' ' . $ones[$num % 10] : '');
        if ($num < 1000) return $ones[floor($num/100)] . ' Hundred' . ($num % 100 ? ' and ' . self::numberToWords($num % 100) : '');
        return self::numberToWords(floor($num/1000)) . ' Thousand' . ($num % 1000 ? ' ' . self::numberToWords($num % 1000) : '');
    }
}