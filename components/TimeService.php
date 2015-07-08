<?php

namespace app\components;

use Yii;
use app\abstracts\ServiceAbstract;

class TimeService extends ServiceAbstract
{
    protected static $_deyNames = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];

    public $dateTimeFormat;
    public $apiDateTimeFormat;
    public $dateFormat;

    public function init()
    {
        if ($this->dateTimeFormat === null) {
            $this->dateTimeFormat = Yii::$app->params['datetime_format'];
        }
        if ($this->apiDateTimeFormat === null) {
            $this->apiDateTimeFormat = Yii::$app->params['api_datetime_format'];
        }
        if ($this->dateFormat === null) {
            $this->dateFormat = Yii::$app->params['date_format'];
        }
    }

    public function formatDate($date, $format = null)
    {
        if ($format === null) {
            $format = $this->dateFormat;
        }

        return $this->getDateTime($date)->format($format);
    }

    public function getCurrentDateTime($format = null)
    {
        if ($format === null) {
            $format = $this->dateTimeFormat;
        }

        return $this->getDateTime()->format($format);
    }

    public function getCurrentDate($format = null)
    {
        if ($format === null) {
            $format = $this->dateFormat;
        }

        return $this->getDateTime()->format($format);
    }

    public function getFrontendDateTime($date = null)
    {
        $date = $date === null ? $this->getDateTime() : $this->getDateTime($date);

        return $date->format(Yii::$app->params['api_datetime_format']);
    }

    public function addSeconds($interval, $time = null, $format = null)
    {
        if ($format === null) {
            $format = $this->dateTimeFormat;
        }

        if ($time === null) {
            $time = $this->getCurrentDateTime();
        }

        $dateInterval = $this->getDateInterval($time);
        $dateInterval->s = $interval;

        return $this->getDateTime($time)->add($dateInterval)->format($format);
    }

    public function apiFormat($time = 'now')
    {
        return $this->getDateTime($time)->format($this->apiDateTimeFormat);
    }

    public function dbFormat($time = 'now')
    {
        return $this->getDateTime($time)->format($this->dateTimeFormat);
    }

    public function getDey($time = 'now')
    {
        return (int)$this->getDateTime($time)->format('w');
    }

    public function getDeyName($time = 'now')
    {
        return self::$_deyNames[$this->getDateTime($time)->format('w')];
    }

    public function getDeyNameBayNumber($dayNumber)
    {
        return isset(self::$_deyNames[$dayNumber]) ? self::$_deyNames[$dayNumber] : self::$_deyNames[0];
    }

    public function getNextDayDate($time = null, $format = null)
    {
        if ($format === null) {
            $format = $this->dateFormat;
        }

        return $this->addSeconds(24*3600, $time, $format);
    }

    /**
     * @param string $time
     * @return \DateTime
     */
    protected function getDateTime($time = 'now')
    {
        return new \DateTime($time);
    }

    /**
     * @param string $time
     * @return \DateInterval
     */
    protected function getDateInterval($time = null)
    {
        if ($time === null) {
            $time = $this->getCurrentDateTime();
        }

        return \DateInterval::createFromDateString($time);
    }
} 