<?php

namespace app\components;

use Yii;
use app\abstracts\ServiceAbstract;
use app\interfaces\StatsModelInterface;
use app\interfaces\AmqpServiceInterface;
use yii\helpers\Json;

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

    public function writeStats($date = null)
    {
        $all = false;

        if ($date === null) {
            $date = Yii::$app->timeService->getCurrentDate();
            $all = true;
        }

        if ($all) {
            $message = [
                'date' => $date,
            ];
            $this->getAmqpService()->send(Yii::$app->params['write_all_week_stats_queue'], $message);
        } else {
            return $this->writeAllWeeksStats($date);
        }

        return true;
    }

    public function writeAllWeeksStats($date, $all = false)
    {
        // Get stats the model object
        $model = $this->getModel();
        $timeService = Yii::$app->timeService;
        $format = $timeService->dateFormat;

        // Find days
        if ($all) {
            $days = $model->findDaysByEndDate($date);
        }else {
            $weighingDay = 0;
            if (!Yii::$app->request->getIsConsoleRequest()) {
                $weighingDay = Yii::$app->user->identity->weighingDay;
            } else {
                $days = $model->findDaysByEndDate($date, 1);
                if (!empty($days)) {
                    $day = $days[0];
                    $weighingDay = $day['weighing_day'];
                }
            }

            list($startDate, $endDate) = $this->getWeekDates($date, $weighingDay, $timeService, $format);
            $days = $model->findDaysByStartAndEndDate($startDate, $endDate);
        }

        if (empty($days)) {
            return false;
        }

        $lastDay = null;
        $startDate = null;
        $endDate = null;
        $userId = null;
        $calories = 0;
        $daysCount = 0;

        $weeks = [];
        foreach ($days as $day) {
            $weighingDay = $day['weighingDay'];
            $date = $day['date'];
            list($startDate, $endDate) = $this->getWeekDates($date, $weighingDay, $timeService, $format);

            $key = $startDate . '::' .  $timeService->addSeconds(-3600*24, $endDate, $format);
            if (!isset($weeks[$key])) {
                $calories = 0;
                $daysCount = 0;

                $weeks[$key] = [
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'calories' => 0,
                    'averageCalories' => 0,
                    'days' => []
                ];
            }

            $record = [
                'id' => $day['id'],
                'date' => $date,
                'calories' => $day['calories']
            ];

            if ($lastDay !== null && $date < $endDate) {
                $weeks[$key]['days'][] = $lastDay;
                $daysCount++;
                $calories += $lastDay['calories'];
                $lastDay = null;
            }

            if ($date >= $endDate) {
                $lastDay = $record;
            } else {
                $daysCount++;
                $calories += $record['calories'];
                $weeks[$key]['days'][] = $record;
            }

            $weeks[$key]['calories'] = $calories;
            if ($daysCount !== 0) {
                $weeks[$key]['averageCalories'] = $calories/$daysCount;
            }

            if ($userId === null) {
                $userId = $day['user_id'];
            }
        }

        if (!empty($weeks)) {
            $this->writeChanges($weeks, $userId);
        }

        return true;
    }

    /**
     * @param string $date
     * @param integer $weighingDay
     * @return array
     */
    public function getWeekLastAndFirstDates($date, $weighingDay)
    {
        $timeService = Yii::$app->timeService;
        $format = $timeService->dateFormat;
        return $this->getWeekDates($date, $weighingDay, $timeService, $format);
    }

    protected function writeChanges($weeks, $userId)
    {
        $model = $this->getModel();
        $db = Yii::$app->getDb();
        $columns = [
            'user_id',
            'start_date',
            'end_date',
            'weight',
            'calories',
            'average_weight',
            'average_calories',
            'body_weight',
            'days_stats'
        ];
        $rows = [];

        foreach ($weeks as $week) {
            $row = [
                'user_id' => $userId,
                'start_date' => $week['startDate'],
                'end_date' => $week['endDate'],
                'weight' => 0,
                'calories' => $week['calories'],
                'average_weight' => 0,
                'average_calories' => $week['averageCalories'],
                'body_weight' => null,
                'days_stats' => Json::encode($week['days']),
            ];

            $weekStat = $model->findByStartAndAndDates($week['startDate'], $week['endDate']);
            if (!empty($weekStat)) {
                $db->createCommand()->update($model->tableName(), $row, ['id' => $weekStat['id']])->execute();
            } else {
                $rows[] = array_values($row);
            }
        }

        if (!empty($rows)) {
            Yii::$app->getDb()->createCommand()->batchInsert($model->tableName(), $columns, $rows)->execute();
        }
    }

    /**
     * @return AmqpServiceInterface
     * @throws \yii\base\InvalidConfigException
     */
    protected function getAmqpService()
    {
        return Yii::$app->get('amqpService');
    }

    /**
     * @return StatsModelInterface
     */
    protected function getModel()
    {
        $class = $this->modelClass;
        return new $class();
    }

    /**
     * @param string $date
     * @param integer $weighingDay
     * @param \app\components\TimeService $timeService
     * @param string $format
     * @return array;
     */
    private function getWeekDates($date, $weighingDay, $timeService, $format)
    {
        $weekDay = $timeService->getDey($date);
        $diff = $weighingDay - $weekDay;
        if ($diff >= 0) {
            $toStart = -(7 - $diff);
            $toEnd = $diff;
        } else {
            $toStart = $diff;
            $toEnd = 7 + $diff;
        }

        $startDate = $timeService->addSeconds($toStart*3600*24, $date, $format);
        $endDate = $timeService->addSeconds($toEnd*3600*24, $date, $format);

        return [$startDate, $endDate];
    }
}