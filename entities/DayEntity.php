<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 01.08.2015
 * Time: 15:53
 */

namespace app\entities;

use Yii;
use app\abstracts\EntityAbstract;

class DayEntity extends EntityAbstract
{
    public $id;
    public $date;
    public $day;
    public $dayName;
    public $weight;
    public $calories;

    public function rules()
    {
        return [
            [['date', 'dayName'], 'string'],
            [['day'], 'integer'],
            [['weight', 'calories'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'data' => $this->t('Date'),
            'day' => $this->t('Day'),
            'dayName' => $this->t('Day'),
            'weight' => $this->t('Weight'),
            'calories' => $this->t('Calories'),
        ];
    }
}