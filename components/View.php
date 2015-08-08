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

    public function t($message, $params = [], $path = 'app', $language = null)
    {
        return Yii::t($path, $message, $params, $language);
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

    public function getFrontendDateFormat()
    {
        return Yii::$app->params['frontend_date_format'];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasFlash($key)
    {
        return Yii::$app->session->hasFlash($key);
    }

    public function getFlash($key, $params = [])
    {
        return $this->t(Yii::$app->session->getFlash($key), $params, 'flash');
    }
}