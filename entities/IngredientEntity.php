<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 21.07.2015
 * Time: 19:05
 */

namespace app\entities;

use Yii;
use app\abstracts\EntityAbstract;

class IngredientEntity extends EntityAbstract
{
    const TYPE_WEIGHT = 'type_weight';
    const TYPE_COUNT = 'type_count';

    public $type;
    public $name;
    public $weight;
    public $count;
    public $calories;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['type', 'name'], 'required'],
            [['type', 'name'], 'string'],
            [['weight', 'count', 'calories'], 'number'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'type' => $this->t('Type'),
            'name' => $this->t('Name'),
            'weight' => $this->t('Weight'),
            'calories' => $this->t('Calories'),
            'count' => $this->t('Count'),
        ]);
    }
}