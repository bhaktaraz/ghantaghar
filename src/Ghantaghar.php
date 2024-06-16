<?php
namespace Bhaktaraz\Ghantaghar;

/**
 * Ghantaghar
 *
 * A simple API extension for Nepali DateTime.
 *
 * @author bhaktaraz bhatta <bhattabhakta@gmail.com>
 */
class Ghantaghar{

    /**
     * The day constants.
     */
    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;

    /**
     * Names of days of the week.
     *
     * @var array
     */
    protected static $days = array(
        self::SUNDAY => 'आइतबार',
        self::MONDAY => 'सोमबार',
        self::TUESDAY => 'मंगलबार',
        self::WEDNESDAY => 'बुधबार',
        self::THURSDAY => 'बिहिबार',
        self::FRIDAY => 'शुक्रबार',
        self::SATURDAY => 'शनिबार',
    );

    /**
     * Terms used to detect if a time passed is a relative date.
     *
     * This is here for testing purposes.
     *
     * @var array
     */
    protected static $relativeKeywords = array(
        '+',
        '-',
        'पहिले',
        'पहिलो',
        'अन्तिम',
        'अर्को',
        'यो',
        'आज',
        'भोलि',
        'हिजो',
    );

    /**
     * Number of X in Y.
     */
    const YEARS_PER_CENTURY = 100;
    const YEARS_PER_DECADE = 10;
    const MONTHS_PER_YEAR = 12;
    const MONTHS_PER_QUARTER = 3;
    const WEEKS_PER_YEAR = 52;
    const DAYS_PER_WEEK = 7;
    const HOURS_PER_DAY = 24;
    const MINUTES_PER_HOUR = 60;
    const SECONDS_PER_MINUTE = 60;

    /**
     * First day of week.
     *
     * @var int
     */
    protected static $weekStartsAt = self::SUNDAY;

    /**
     * Last day of week.
     *
     * @var int
     */
    protected static $weekEndsAt = self::SATURDAY;

    /**
     * Days of weekend.
     *
     * @var array
     */
    protected static $weekendDays = array(
        self::FRIDAY,
        self::SATURDAY,
    );

    protected static $bs = [
        0 => [2000, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1 => [2001, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2 => [2002, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        3 => [2003, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        4 => [2004, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        5 => [2005, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        6 => [2006, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        7 => [2007, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        8 => [2008, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31],
        9 => [2009, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        10 => [2010, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        11 => [2011, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        12 => [2012, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        13 => [2013, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        14 => [2014, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        15 => [2015, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        16 => [2016, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        17 => [2017, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        18 => [2018, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        19 => [2019, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        20 => [2020, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        21 => [2021, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        22 => [2022, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        23 => [2023, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        24 => [2024, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        25 => [2025, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        26 => [2026, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        27 => [2027, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        28 => [2028, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        29 => [2029, 31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        30 => [2030, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        31 => [2031, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        32 => [2032, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        33 => [2033, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        34 => [2034, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        35 => [2035, 30, 32, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31],
        36 => [2036, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        37 => [2037, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        38 => [2038, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        39 => [2039, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        40 => [2040, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        41 => [2041, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        42 => [2042, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        43 => [2043, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        44 => [2044, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        45 => [2045, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        46 => [2046, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        47 => [2047, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        48 => [2048, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        49 => [2049, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        50 => [2050, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        51 => [2051, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        52 => [2052, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        53 => [2053, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        54 => [2054, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        55 => [2055, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        56 => [2056, 31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        57 => [2057, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        58 => [2058, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        59 => [2059, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        60 => [2060, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        61 => [2061, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        62 => [2062, 30, 32, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31],
        63 => [2063, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        64 => [2064, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        65 => [2065, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        66 => [2066, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31],
        67 => [2067, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        68 => [2068, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        69 => [2069, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        70 => [2070, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        71 => [2071, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        72 => [2072, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        73 => [2073, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        74 => [2074, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        75 => [2075, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        76 => [2076, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        77 => [2077, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        78 => [2078, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        79 => [2079, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        80 => [2080, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        81 => [2081, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        82 => [2082, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        83 => [2083, 31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30],
        84 => [2084, 31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30],
        85 => [2085, 31, 32, 31, 32, 30, 31, 30, 30, 29, 30, 30, 30],
        86 => [2086, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        87 => [2087, 31, 31, 32, 31, 31, 31, 30, 30, 29, 30, 30, 30],
        88 => [2088, 30, 31, 32, 32, 30, 31, 30, 30, 29, 30, 30, 30],
        89 => [2089, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        90 => [2090, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30]
    ];

    private static $nep_date = ['year' => '', 'month' => '', 'date' => '', 'day' => '', 'nmonth' => '', 'num_day' => ''];

    private static $eng_date = ['year' => '', 'month' => '', 'date' => '', 'day' => '', 'emonth' => '', 'num_day' => ''];

    public $debug_info = "";


    /**
     * Calculates wheather english year is leap year or not
     *
     * @param integer $year
     * @return boolean
     */
    public function is_leap_year($year)
    {
        $a = $year;
        if ($a % 100 == 0) {
            if ($a % 400 == 0) {
                return true;
            } else {
                return false;
            }

        } else {
            if ($a % 4 == 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function get_nepali_month($m)
    {
        $n_month = false;

        switch ($m) {
            case 1:
                $n_month = "Baishakh";
                break;

            case 2:
                $n_month = "Jestha";
                break;

            case 3:
                $n_month = "Ashad";
                break;

            case 4:
                $n_month = "Shrawan";
                break;

            case 5:
                $n_month = "Bhadra";
                break;

            case 6:
                $n_month = "Ashwin";
                break;

            case 7:
                $n_month = "Kartik";
                break;

            case 8:
                $n_month = "Mangshir";
                break;

            case 9:
                $n_month = "Poush";
                break;

            case 10:
                $n_month = "Magh";
                break;

            case 11:
                $n_month = "Falgun";
                break;

            case 12:
                $n_month = "Chaitra";
                break;
        }

        return $n_month;
    }

    private function get_english_month($m)
    {
        $eMonth = false;
        switch ($m) {
            case 1:
                $eMonth = "January";
                break;
            case 2:
                $eMonth = "February";
                break;
            case 3:
                $eMonth = "March";
                break;
            case 4:
                $eMonth = "April";
                break;
            case 5:
                $eMonth = "May";
                break;
            case 6:
                $eMonth = "June";
                break;
            case 7:
                $eMonth = "July";
                break;
            case 8:
                $eMonth = "August";
                break;
            case 9:
                $eMonth = "September";
                break;
            case 10:
                $eMonth = "October";
                break;
            case 11:
                $eMonth = "November";
                break;
            case 12:
                $eMonth = "December";
        }

        return $eMonth;
    }

    private function get_day_of_week($day)
    {
        switch ($day) {
            case 1:
                $day = "Sunday";
                break;

            case 2:
                $day = "Monday";
                break;

            case 3:
                $day = "Tuesday";
                break;

            case 4:
                $day = "Wednesday";
                break;

            case 5:
                $day = "Thursday";
                break;

            case 6:
                $day = "Friday";
                break;

            case 7:
                $day = "Saturday";
                break;
        }

        return $day;
    }


    public function is_range_eng($yy, $mm, $dd)
    {
        if ($yy < 1944 || $yy > 2033) {
            $this->debug_info = "Supported only between 1944-2033";

            return false;
        }

        if ($mm < 1 || $mm > 12) {
            $this->debug_info = "Error! value 1-12 only";

            return false;
        }

        if ($dd < 1 || $dd > 31) {
            $this->debug_info = "Error! value 1-31 only";

            return false;
        }

        return true;
    }

    public function is_range_nep($yy, $mm, $dd)
    {
        if ($yy < 2000 || $yy > 2089) {
            $this->debug_info = "Supported only between 2000-2089";

            return false;
        }

        if ($mm < 1 || $mm > 12) {
            $this->debug_info = "Error! value 1-12 only";

            return false;
        }

        if ($dd < 1 || $dd > 32) {
            $this->debug_info = "Error! value 1-31 only";

            return false;
        }

        return true;
    }


    /**
     * currently can only calculate the date between AD 1944-2033...
     *
     * @param unknown_type $yy
     * @param unknown_type $mm
     * @param unknown_type $dd
     * @return unknown
     */

    public static function eng_to_nep($yy, $mm, $dd)
    {
        if (self::is_range_eng($yy, $mm, $dd) == false) {
            return false;
        } else {
            // english month data.
            $month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            $lmonth = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

            $def_eyy = 1944;                                    //spear head english date...
            $def_nyy = 2000;
            $def_nmm = 9;
            $def_ndd = 17 - 1;        //spear head nepali date...
            $total_eDays = 0;
            $total_nDays = 0;
            $a = 0;
            $day = 7 - 1;        //all the initializations...
            $m = 0;
            $y = 0;
            $i = 0;
            $j = 0;
            $numDay = 0;

            // count total no. of days in-terms of year
            for ($i = 0; $i < ($yy - $def_eyy); $i++) {    //total days for month calculation...(english)
                if (self::is_leap_year($def_eyy + $i) == 1) {
                    for ($j = 0; $j < 12; $j++) {
                        $total_eDays += $lmonth[$j];
                    }
                } else {
                    for ($j = 0; $j < 12; $j++) {
                        $total_eDays += $month[$j];
                    }
                }
            }

            // count total no. of days in-terms of month
            for ($i = 0; $i < ($mm - 1); $i++) {
                if (self::is_leap_year($yy) == 1) {
                    $total_eDays += $lmonth[$i];
                } else {
                    $total_eDays += $month[$i];
                }
            }

            // count total no. of days in-terms of date
            $total_eDays += $dd;


            $i = 0;
            $j = $def_nmm;
            $total_nDays = $def_ndd;
            $m = $def_nmm;
            $y = $def_nyy;

            // count nepali date from array
            while ($total_eDays != 0) {
                $a = self::$bs[$i][$j];
                $total_nDays++;                        //count the days
                $day++;                                //count the days interms of 7 days
                if ($total_nDays > $a) {
                    $m++;
                    $total_nDays = 1;
                    $j++;
                }
                if ($day > 7) {
                    $day = 1;
                }
                if ($m > 12) {
                    $y++;
                    $m = 1;
                }
                if ($j > 12) {
                    $j = 1;
                    $i++;
                }
                $total_eDays--;
            }

            $numDay = $day;

            self::$nep_date["year"] = $y;
            self::$nep_date["month"] = $m;
            self::$nep_date["date"] = $total_nDays;
            self::$nep_date["day"] = self::get_day_of_week($day);
            self::$nep_date["month_name"] = self::get_nepali_month($m);
            self::$nep_date["num_day"] = $numDay;

            return self::$nep_date;
        }
    }


    /**
     * currently can only calculate the date between BS 2000-2089
     *
     * @param integer $yy
     * @param integer $mm
     * @param integer $dd
     * @return array
     */
    private function n_to_e($yy, $mm, $dd)
    {

        $def_eyy = 1943;
        $def_emm = 4;
        $def_edd = 14 - 1;        // init english date.
        $def_nyy = 2000;
        $def_nmm = 1;
        $def_ndd = 1;        // equivalent nepali date.
        $total_eDays = 0;
        $total_nDays = 0;
        $a = 0;
        $day = 4 - 1;        // initializations...
        $m = 0;
        $y = 0;
        $i = 0;
        $k = 0;
        $numDay = 0;

        $month = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $lmonth = [0, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        if (self::is_range_nep($yy, $mm, $dd) === false) {
            return false;

        } else {

            // count total days in-terms of year
            for ($i = 0; $i < ($yy - $def_nyy); $i++) {
                for ($j = 1; $j <= 12; $j++) {
                    $total_nDays += self::bs[$k][$j];
                }
                $k++;
            }

            // count total days in-terms of month
            for ($j = 1; $j < $mm; $j++) {
                $total_nDays += self::bs[$k][$j];
            }

            // count total days in-terms of dat
            $total_nDays += $dd;

            //calculation of equivalent english date...
            $total_eDays = $def_edd;
            $m = $def_emm;
            $y = $def_eyy;
            while ($total_nDays != 0) {
                if (self::is_leap_year($y)) {
                    $a = $lmonth[$m];
                } else {
                    $a = $month[$m];
                }
                $total_eDays++;
                $day++;
                if ($total_eDays > $a) {
                    $m++;
                    $total_eDays = 1;
                    if ($m > 12) {
                        $y++;
                        $m = 1;
                    }
                }
                if ($day > 7) {
                    $day = 1;
                }
                $total_nDays--;
            }
            $numDay = $day;

            self::$eng_date["year"] = $y;
            self::$eng_date["month"] = $m;
            self::$eng_date["date"] = $total_eDays;
            self::$eng_date["day"] = self::get_day_of_week($day);
            self::$eng_date["month_name"] = self::get_english_month($m);
            self::$eng_date["num_day"] = $numDay;

            return self::$eng_date;

        }
    }

    ///////////////////////////////////////////////
    public function nep_to_eng($yy, $mm, $dd)
    {
        $arr = self::n_to_e($yy, $mm, $dd);
        $et_year = $arr['year'];
        $et_month = $arr['month'];
        $et_date = $arr['date'];
        $new_nep = self::eng_to_nep($et_year, $et_month, $et_date);
        //showpre($new_nep,'new_nep');
        //showpre($yy.' '.$mm.' '.$dd,'original');
        //showpre($arr,'eng');
        //showpre($new_nep,'new nep');
        if ($new_nep['year'] == $yy && $new_nep['month'] == $mm && $new_nep['date'] == $dd) {
            return $arr;
        } else {
            $err_arr['error'] = 1;
            $err_arr['error_message'] = 'Invalid Date';

            return $err_arr;
        }
    }

    /**
     * Returns the total days in a particur month of a year
     * @param  Integer $year
     * @param  Integer $month
     * @return Integer        Total days in a month of a given year
     */
    public function get_total_days_of($year, $month)
    {
        $yearShort = (int)$year % 100;

        return isset(self::_bs[$yearShort]) ? self::_bs[$yearShort][(int)$month] : null;
    }

    /**
     * Convert date to days
     * Reference date is the start of the year
     *
     * @param  Date $date date whose day is to be calculated
     * @return int total days upto the date
     * @throws Exception
     */
    private function date_to_day($date)
    {
        @list($year, $month, $day) = explode('-', $date);
        if (self::is_range_nep($year, $month, $day) === false) {
            throw new Exception("Date out of range");
        }

        $yearShort = (int)$year % 100;

        $current_year_days = self::_bs[$yearShort];

        array_splice($current_year_days, $month);
        $required_months = array_splice($current_year_days, 1);

        if (!empty($required_months) && is_array($required_months)) {
            return array_sum($required_months) + $day;
        } else {
            return $day;
        }
    }

    /**
     * Get total days of a given year
     * @param  Integer $year
     * @return Integer       total days in a year
     */
    public function total_days_in_year($year)
    {
        if (self::is_range_nep($year, 01, 01) === false) {
            throw new Exception("Date out of range");
        }

        $yearShort = (int)$year % 100;

        $current_year_days = self::_bs[$yearShort];
        $required_months = array_splice($current_year_days, 1);

        if (!empty($required_months) && is_array($required_months)) {
            return array_sum($required_months);
        } else {
            return null;
        }
    }

    /**
     * Returns the total number of days between the given dates
     * @param  Date $start_date
     * @param  Date $end_date
     * @return Integer total number of days between start and end date
     */
    public function days_between($start_date, $end_date)
    {

        @list($sYear, $month, $day) = explode('-', $start_date);
        if (self::is_range_nep($sYear, $month, $day) === false) {
            throw new Exception("Date out of range");
        }

        @list($eYear, $month, $day) = explode('-', $end_date);
        if (self::is_range_nep($eYear, $month, $day) === false) {
            throw new Exception("Date out of range");
        }

        if ($eYear < $sYear) {
            throw new Exception("End year should be greater than the start year");
        }

        if (($eYear - $sYear) == 0) {
            //same year
            return (self::date_to_day($end_date) - self::date_to_day($start_date) + 1);
        } else {
            //different year
            $startYearDays = self::total_days_in_year($sYear) - self::date_to_day($start_date);
            $endYearDays = self::date_to_day($end_date);

            $days = $startYearDays + $endYearDays;
            for ($i = $sYear + 1; $i < $eYear; $i++) {
                $days += self::total_days_in_year($i);
            }

            return abs($days);
        }
    }

    /**
     * @param $num
     * @return string
     */
    private function getNepaliNumber($num)
    {
        $str = [];
        $numarr = str_split($num);
        if (count($numarr) == 1) {
            array_unshift($numarr, '0');
        }
        $number = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
        for ($i = 0; $i < count($numarr); $i++) {
            $str[$i] = $number[$numarr[$i]];
        }

        return implode('', $str);
    }

    private function getMahina($num)
    {
        $bar = ['बैशाख', 'जेठ', 'असार', 'साउन', 'भदौ', 'असोज', 'कार्तिक', 'मङि्सर', 'पुष', 'माघ', 'फागुन', 'चैत'];
        $ret = $bar[$num - 1];

        return $ret;
    }

    private function getBaar($num)
    {
        $bar = ['आइतबार', 'सोमबार', 'मङ्गलबार', 'बुधबार', 'बिहिबार', 'शुक्रबार', 'शनिबार'];
        $ret = $bar[$num - 1];

        return ($ret);
    }

    /**
     * @param $dateArray
     * @return array
     */
    public static function englishToNepaliDate($dateArray)
    {
        $nepaliDate = [];
        $convertedDate = self::eng_to_nep((int)$dateArray[0], (int)$dateArray[1], (int)$dateArray[2]);
        $nepaliDate['year'] = self::getNepaliNumber($convertedDate['year']);
        $nepaliDate['month_name'] = self::getMahina($convertedDate['month']);
        $nepaliDate['month'] = self::getNepaliNumber($convertedDate['month']);
        $nepaliDate['day'] = self::getBaar($convertedDate['num_day']);
        $nepaliDate['date'] = self::getNepaliNumber($convertedDate['date']);
        $nepaliDate['num_day'] = self::getNepaliNumber($convertedDate['num_day']);

        return $nepaliDate;
    }

    /**
     * @param null $format
     * @return string
     */
    public function now($format = null)
    {
        $now = date('Y-m-d h:i:s');

        $dateTime = explode(' ', $now);

        $dateArray = explode('-', $dateTime[0]);
        $timeArray = explode(':', $dateTime[1]);

        $hour = $timeArray[0];

        $nepaliDate = self::englishToNepaliDate($dateArray);

        $nepaliTime['hour'] = self::getNepaliNumber($hour);
        $nepaliTime['minutes'] = self::getNepaliNumber($timeArray[1]);
        $nepaliTime['seconds'] = self::getNepaliNumber($timeArray[2]);

        if($format=='w D, m Y h:i:s'){
            return $nepaliDate['day'].' '.$nepaliDate['date'].', '.$nepaliDate['month_name'].' '.$nepaliDate['year'].' '.$nepaliTime['hour'].':'.$nepaliTime['minutes'].':'.$nepaliTime['seconds'];
        }

        if($format=='w D, m Y'){
            return $nepaliDate['day'].' '.$nepaliDate['date'].', '.$nepaliDate['month_name'].' '.$nepaliDate['year'];
        }

        if($format=='h:i:s'){
            return $nepaliTime['hour'].':'.$nepaliTime['minutes'].':'.$nepaliTime['seconds'];
        }

        return $nepaliDate['year'].'/'.$nepaliDate['month'].'/'.$nepaliDate['date'].' '.$nepaliTime['hour'].':'.$nepaliTime['minutes'].':'.$nepaliTime['seconds'];
    }

    /**
     * @param null $format
     * @return string
     */
    public function today($format = null)
    {
        $now = date('Y-m-d h:i:s');

        $dateTime = explode(' ', $now);

        $dateArray = explode('-', $dateTime[0]);
        $timeArray = explode(':', $dateTime[1]);

        $hour = $timeArray[0];

        $nepaliTime['hour'] = self::getNepaliNumber($hour);
        $nepaliTime['minutes'] = self::getNepaliNumber($timeArray[1]);
        $nepaliTime['seconds'] = self::getNepaliNumber($timeArray[2]);

        $nepaliDate = self::englishToNepaliDate($dateArray);

        if($format=='w D, m Y h:i:s'){
            return $nepaliDate['day'].' '.$nepaliDate['date'].', '.$nepaliDate['month_name'].' '.$nepaliDate['year'].' '.$nepaliTime['hour'].':'.$nepaliTime['minutes'].':'.$nepaliTime['seconds'];
        }

        if($format=='w D, m Y'){
            return $nepaliDate['day'].' '.$nepaliDate['date'].', '.$nepaliDate['month_name'].' '.$nepaliDate['year'];
        }

        if($format=='h:i:s'){
            return $nepaliTime['hour'].':'.$nepaliTime['minutes'].':'.$nepaliTime['seconds'];
        }

        return $nepaliDate['year'].'/'.$nepaliDate['month'].'/'.$nepaliDate['date'];
    }

    /**
     * @param $dateTimeString 'Y-m-d H:i:s format
     * @return mixed
     */
    public function convertDateToNepaliDateTime($dateTimeString)
    {
        $dateTime = explode(' ', $dateTimeString);
        $dateArray = explode('-', $dateTime[0]);
        $timeArray = explode(':', $dateTime[1]);

        $hour = $timeArray[0];

        $nepaliTime['hour'] = self::getNepaliNumber($hour);
        $nepaliTime['minutes'] = self::getNepaliNumber($timeArray[1]);
        $nepaliTime['seconds'] = self::getNepaliNumber($timeArray[2]);

        $hour = $timeArray[0];
        $nepaliDate = self::englishToNepaliDate($dateArray);
        $nepaliTime['hour'] = self::getNepaliNumber($hour);
        $nepaliTime['minutes'] = self::getNepaliNumber($timeArray[1]);
        $nepaliTime['seconds'] = self::getNepaliNumber($timeArray[2]);

        return compact('nepaliDate', 'nepaliTime');
    }

    /**
     * @param $date
     * @param null $format
     * @return mixed
     */
    public static function convertDateToBs($date, $format=null)
    {
        $dateTime = explode(' ', $date);
        $dateArray = explode('-', $dateTime[0]);
        $timeArray = explode(':', $dateTime[1]);

        $hour = $timeArray[0];

        $nepaliTime['hour'] = self::getNepaliNumber($hour);
        $nepaliTime['minutes'] = self::getNepaliNumber($timeArray[1]);
        $nepaliTime['seconds'] = self::getNepaliNumber($timeArray[2]);

        $hour = $timeArray[0];
        $nepaliDate = self::englishToNepaliDate($dateArray);
        $nepaliTime['hour'] = self::getNepaliNumber($hour);
        $nepaliTime['minutes'] = self::getNepaliNumber($timeArray[1]);
        $nepaliTime['seconds'] = self::getNepaliNumber($timeArray[2]);

        if(!is_null($format)){
            if($format=='w D, m Y h:i:s'){
                return $nepaliDate['day'].' '.$nepaliDate['date'].', '.$nepaliDate['month_name'].' '.$nepaliDate['year'].' '.$nepaliTime['hour'].':'.$nepaliTime['minutes'].':'.$nepaliTime['seconds'];
            }

            if($format=='Y m d w'){
                return $nepaliDate['year'].' '.$nepaliDate['month_name'].' '.$nepaliDate['date'].' '.$nepaliDate['day'];
            }
        }

        return $nepaliDate['year'].'/'.$nepaliDate['month'].'/'.$nepaliDate['date'];
    }

    /**
     * Determines if the instance is a weekend day
     *
     * @return bool
     */
    public function isWeekend()
    {
        return in_array(date('w'), static::$weekendDays);
    }
}