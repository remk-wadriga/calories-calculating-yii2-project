<?php

namespace app\abstracts;

use Yii;
use yii\db\ActiveRecord;

class ModelAbstract extends ActiveRecord
{
    public function modelName()
    {
        $classParts = explode('\\', self::className());
        return end($classParts);
    }

    public function t($message, $params = [], $language = null)
    {
        return Yii::$app->view->t($message, $params, $language);
    }
}