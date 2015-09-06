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

    public function t($message, $params = [], $direction = 'app')
    {
        return Yii::$app->view->t($message, $params, $direction);
    }

    public function getChangedAttributes()
    {
        $changedAttributes = [];
        foreach ((array_keys($this->getAttributes())) as $attribute) {
            if ($this->isAttributeChanged($attribute)) {
                $changedAttributes[] = $attribute;
            }
        }
        return $changedAttributes;
    }
}