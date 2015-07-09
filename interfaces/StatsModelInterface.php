<?php

namespace app\interfaces;


interface StatsModelInterface
{
    /**
     * @param string $date
     * @param integer|null $limit
     * @return array
     */
    public function findDaysByEndDate($date, $limit = null);

    /**
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function findDaysByStartAndEndDate($startDate, $endDate);

    /**
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function findByStartAndAndDates($startDate, $endDate);
}