<?php

namespace app\abstracts;

use Yii;
use yii\base\Model;

abstract class FormAbstract extends Model
{
    public function t($message, $params = [], $language = null)
    {
        return Yii::$app->view->t($message, $params, $language);
    }
}