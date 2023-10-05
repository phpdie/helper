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

    /** 两时间相差多少年月日时分秒
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public static function diff(string $startDate, string $endDate): array
    {
        $origin = date_create($startDate);
        $target = date_create($endDate);

        $interval = date_diff($origin, $target);

        $character = ['y', 'm', 'd', 'h', 'i', 's'];

        $result = [];
        foreach ($character as $c) {
            $result[] = [$c => $interval->format('%' . $c)];
        }

        return $result;
    }

    /** 两时间相差多少天或时或分或秒
     * @param string $startDate
     * @param string $endDate
     * @param string $char
     * @return int
     */
    public static function diffTime(string $startDate, string $endDate, string $char = 'd'): int
    {
        $origin = strtotime($startDate);
        $target = strtotime($endDate);

        $diff = $target - $origin;
        $character = [
            's' => 1,
            'i' => 60,
            'h' => 60 * 60,
            'd' => 60 * 60 * 24
        ];

        return sprintf("%.2f", $diff / $character[$char]);
    }
}