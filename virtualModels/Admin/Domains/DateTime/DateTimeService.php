<?php

namespace app\virtualModels\Admin\Domains\DateTime;

class DateTimeService
{
    public $timezone = 'Europe/Moscow';

    /**
     * Дней между датами
     *
     * @param $from
     * @param $to
     * @return float
     */
    public function daysBetweenDates($from, $to)
    {
        $fromStamp = strtotime($from);
        $toStamp = strtotime($to);
        $datediff = $toStamp - $fromStamp;
        $result = round($datediff / (60 * 60 * 24));

        return $result;
    }

    /**
     * Разбить даты на равные части
     *
     * @param $min
     * @param $max
     * @param int $parts
     * @param string $output
     * @return array
     */
    public function splitDatesEqually($min, $max, $parts = 7, $output = "Y-m-d")
    {
        $dataCollection[] = date($output, strtotime($min));
        $diff = (strtotime($max) - strtotime($min)) / $parts;
        $convert = strtotime($min) + $diff;

        for ($i = 1; $i < $parts; $i++) {
            $dataCollection[] = date($output, $convert);
            $convert += $diff;
        }
        $dataCollection[] = date($output, strtotime($max));

        return $dataCollection;
    }

    /**
     * Получить массив одинаковых отрезков дат в промежутке между датами
     *
     * @param $min
     * @param $max
     * @param $parts
     * @param string $output
     * @return array
     */
    public function splitDatesToEqualRanges($min, $max, $parts, $output = 'Y-m-d')
    {
        $intevals = $this->splitDatesEqually($min, $max, $parts, $output);

        $ranges = [];
        $counter = 1;

        for ($i = 0; $i<count($intevals);$i++) {
            $current = $intevals[$i];
            $next = isset($intevals[$i+1]) ? $intevals[$i+1] : null;

            if (!$next) {
                break;
            }

            $ranges[$counter] = [$current, $next];
            $counter++;
        }

        return $ranges;
    }

    public function now()
    {
        return (new \DateTime('now', new \DateTimeZone($this->timezone)))->format('Y-m-d H:i:s');
    }

    public function lastDaysRange($daysAgo = '-7 day', $splitParts = 7, $nowOffsetDays = 0)
    {
        $now = $this->now();

        if ($nowOffsetDays !== 0) {
            $now = date('Y-m-d H:i:s', strtotime($nowOffsetDays.' day', strtotime($now)));
        }

        $weekAgo = date('Y-m-d H:i:s', strtotime($daysAgo, strtotime($now)));

        return $this->splitDatesToEqualRanges($weekAgo, $now, $splitParts);
    }
}
