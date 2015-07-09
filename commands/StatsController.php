<?php

namespace app\commands;

use Yii;
use yii\base\ErrorException;
use yii\console\Controller;
use app\interfaces\AmqpServiceInterface;

class StatsController extends Controller
{
    public function actionIndex()
    {
        $callback = function($message){
            echo "\n\n<---------------------------------------------------->\n";
            if (!is_array($message)) {
                throw new ErrorException("Invalid message format");
            }

            $date = isset($message['date']) ? $message['date'] : Yii::$app->timeService->getCurrentDate();

            Yii::$app->statsService->writeAllWeeksStats($date, true);

            echo "\nThe stats was writing\n";
        };

        echo "Weighing for new stats messages\n";

        $this->getAmqpService()->receive($this->getQueue(), $callback);
    }

    public function actionUpdate()
    {
        Yii::$app->statsService->writeStats();
        echo "\nMessage for updating stats was sand\n";
    }

    protected function getQueue()
    {
        return Yii::$app->params['write_all_week_stats_queue'];
    }

    /**
     * @return AmqpServiceInterface
     * @throws \yii\base\InvalidConfigException
     */
    protected function getAmqpService()
    {
        return Yii::$app->get('amqpService');
    }
}