<?php
/**
 * Coypright © 2013 Neilsen Chan. All rights reserved.
 * Author: chenjinlong
 * Date: 5/25/13
 * Time: 5:39 PM
 * Description: LBSDatetime.php
 */ 
class LBSDatetime 
{
    /**
     * Get the max day for specific ym
     *
     * @param $month
     * @param $year
     * @return int
     */
    public static function getMonthLastDay($month, $year) {
        switch ($month) {
            case 2 :
                if ($year % 4 == 0) {
                    if ($year % 100 == 0) {
                        $days = $year % 400 == 0 ? 29 : 28;
                    } else {
                        $days = 29;
                    }
                } else {
                    $days = 28;
                }
                break;
            case 4 :
            case 6 :
            case 9 :
            case 11 :
                $days = 30;
                break;
            default :
                $days = 31;
                break;
        }
        return $days;
    }

    /**
     * Get a custom date by rule str
     *
     * @param $dateChangeString
     * @param $standarDate
     * @return bool|string
     * @throws Exception
     */
    public static function getCustomDate($dateChangeString, $standarDate)
    {
        if(preg_match('/^[+-]\d+$/i', $dateChangeString)){
            $targetDate = date( "Y-m-d", strtotime(strval($dateChangeString).' day', strtotime($standarDate)));
            return $targetDate;
        }else{
            throw new Exception('Invalid arg[0] of func.');
        }
    }

}
