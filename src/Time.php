<?php

namespace Helper;

use DateTimeZone;

class Time
{
    /** 返回指定的起止时间内符合某个星期的日期
     * @param string $startDate
     * @param string $endDate
     * @param int $dayOfWeek
     * @return array
     */
    public static function getWeekOfDay(string $startDate, string $endDate, int $dayOfWeek = 0): array
    {
        if ($dayOfWeek > 6) {
            $dayOfWeek = 0;
        }
        $result = [];
        $currentDayOfWeek = date('w', strtotime($startDate));

        for ($i = 1; $currentDay = date('Y-m-d', strtotime($startDate . " +{$i}day")); $i++) {
            if ($currentDayOfWeek == $dayOfWeek) {
                $result[] = $currentDay;
            }
            $currentDayOfWeek = date('w', strtotime($currentDay));
            if ($currentDay > $endDate) {
                break;
            }
        }

        return $result;
    }

    /** 按指定格式返回指定时区的当前时间
     * @param string $format
     * @param string $timezone
     * @return string
     */
    public static function timeZoneTime(string $format = 'Y-m-d H:i:s', string $timezone = 'PRC'): string
    {
        return date_create('now', (new DateTimeZone($timezone)))->format($format);
    }

    /** 生成连续的日期
     * @param string $startDate
     * @param string $endDate
     * @param string $format
     * @return array
     */
    public static function generateContinuityDays(string $startDate, string $endDate, string $format = 'Y-m-d'): array
    {
        if ($startDate === $endDate) {
            return [$startDate];
        }
        if ($startDate > $endDate) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }
        $return = [$startDate];

        for ($start = date($format, strtotime($startDate . '+1day'));
             $start <= $endDate;
             $start = date($format, strtotime($start . '+1day'))) {
            $return[] = $start;
        }

        return $return;
    }
}