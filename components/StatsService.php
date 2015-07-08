<?php

namespace app\components;

use Yii;
use app\abstracts\ServiceAbstract;
use app\interfaces\StatsModelInterface;

/**
 * Class StatsService
 * @package app\components
 *
 * @property StatsModelInterface $model
 */
class StatsService extends ServiceAbstract
{
    protected static $_weekDays;

    protected static $_weekDaysArray = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
    ];

    public $modelClass = 'app\models\WeekStats';

    /**
     * @return array
     */
    public function getWeekDays()
    {
        if (self::$_weekDays !== null) {
            return self::$_weekDays;
        }

        $view = Yii::$app->view;
        foreach (self::$_weekDaysArray as $id => $name) {
            self::$_weekDays[$id] = $view->t($name);
        }

        return self::$_weekDays;
    }
}