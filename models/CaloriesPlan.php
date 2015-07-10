<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "calories_plan".
 *
 * @property integer $id
 * @property integer $user_id
 * @property float $calories
 * @property string $date
 *
 * @property integer $userId
 */
class CaloriesPlan extends ModelAbstract
{
    public static function tableName()
    {
        return 'calories_plan';
    }

    public function rules()
    {
        return [
            [['calories'], 'required'],
            [['user_id', 'calories', 'userId'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'calories' => 'Calories',
            'date' => 'Date',
        ];
    }


    // Event handlers

    public function beforeSave($insert)
    {
        if ($this->user_id === null) {
            $this->user_id = Yii::$app->user->id;
        }
        if ($this->date === null) {
            $this->date = Yii::$app->timeService->getCurrentDate();
        }

        return parent::beforeSave($insert);
    }

    // END Event handlers



    // Getters and setters

    /**
     * @param integer $value
     * @return $this
     */
    public function setUserId($value)
    {
        $this->user_id = $value;
        return $this;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    // END Getters and setters
}
