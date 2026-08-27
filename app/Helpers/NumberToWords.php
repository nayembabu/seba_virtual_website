<?php

namespace App\Helpers;

class NumberToWords
{
    private static $ordinals = [
        1 => 'First', 2 => 'Second', 3 => 'Third', 4 => 'Fourth', 5 => 'Fifth',
        6 => 'Sixth', 7 => 'Seventh', 8 => 'Eighth', 9 => 'Ninth', 10 => 'Tenth',
        11 => 'Eleventh', 12 => 'Twelfth', 13 => 'Thirteenth', 14 => 'Fourteenth',
        15 => 'Fifteenth', 16 => 'Sixteenth', 17 => 'Seventeenth', 
        18 => 'Eighteenth', 19 => 'Nineteenth', 20 => 'Twentieth',
        21 => 'Twenty First', 22 => 'Twenty Second', 23 => 'Twenty Third',
        24 => 'Twenty Fourth', 25 => 'Twenty Fifth', 26 => 'Twenty Sixth',
        27 => 'Twenty Seventh', 28 => 'Twenty Eighth', 29 => 'Twenty Ninth',
        30 => 'Thirtieth', 31 => 'Thirty First'
    ];

    private static $months = [
        '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
        '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
        '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
    ];

    public static function dateToWords($date)
    {
        // Expecting date in format YYYY-MM-DD
        $parts = explode('-', $date);
        if (count($parts) !== 3) {
            return '';
        }

        $year = $parts[0];
        $month = $parts[1];
        $day = (int)$parts[2];

        // Get ordinal day
        $dayWord = self::$ordinals[$day];

        // Get month name
        $monthWord = self::$months[$month];

        // Convert year to words
        $yearWords = '';
        if ($year >= 2000) {
            $yearWords = 'Two Thousand';
            $remainingYear = (int)substr($year, 2);
            if ($remainingYear > 0) {
                if ($remainingYear < 10) {
                    $yearWords .= ' ' . self::$ordinals[$remainingYear];
                } else {
                    $tensDigit = floor($remainingYear/10);
                    $onesDigit = $remainingYear % 10;
                    if ($onesDigit === 0) {
                        $yearWords .= ' ' . ($tensDigit === 2 ? 'Twenty' : 'Thirty');
                    } else {
                        $yearWords .= ' ' . self::$ordinals[$remainingYear];
                    }
                }
            }
        }

        return "$dayWord of $monthWord $yearWords";
    }
}
