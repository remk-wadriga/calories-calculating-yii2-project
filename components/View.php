<?php

namespace app\components;

use Yii;
use yii\web\View as YiiView;


/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 13.05.2015
 * Time: 13:54
 */
class View extends YiiView
{
    /**
     * Returns routes string for javascript
     *
     * @return string
     */
    public function getRules()
    {
        $routesString = '{';
        foreach (Yii::$app->urlManager->rules as $rule) {
            $routesString .= '"' . $rule->route . '": "' . $rule->name . '", ';
        }

        return substr($routesString, 0, strlen($routesString) - 2) . '}';
    }

    public function t($message, $params = [], $language = null)
    {
        return Yii::t('app', $message, $params, $language);
    }

    public function round($value, $precision = null)
    {
        if ($precision === null) {
            $precision = Yii::$app->params['default_view_round_precision'];
        }

        return round($value, $precision);
    }

    public function getCurrentDate()
    {
        return Yii::$app->timeService->getCurrentDate();
    }

    public function getDayName($day)
    {
        return $this->t(Yii::$app->timeService->getDeyNameBayNumber($day));
    }
}