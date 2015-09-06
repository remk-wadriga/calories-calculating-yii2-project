<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "training_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $trainingsCount
 *
 * @property \app\models\Training[] $trainings
 */
class TrainingCategory extends ModelAbstract
{
    protected static $_items;
    protected $_trainingsCount;

    public static function tableName()
    {
        return 'training_category';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['trainingsCount'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'name' => $this->t('Name'),
            'trainingsCount' => $this->t('Trainings count'),
        ];
    }

    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainings()
    {
        return $this->hasMany(Training::className(), ['category_id' => 'id'])->from(['t' => Training::tableName()]);
    }

    // END Depending


    // Event handlers

    // END Event handlers


    // Getters and setters

    public function getTrainingsCount()
    {
        if ($this->_trainingsCount !== null) {
            return $this->_trainingsCount;
        }

        $this->_trainingsCount = 0;

        return $this->_trainingsCount = $this->getTrainings()->count();
    }

    public function setTrainingsCount($count)
    {
        $this->_trainingsCount = $count;
    }

    // Getters and setters


    // Public methods

    public static function getItems()
    {
        if (self::$_items !== null) {
            return self::$_items;
        }

        self::$_items = [];

        $query = self::find()
            ->orderBy('name')
            ->asArray();

        $list = $query->all();
        if (!empty($list)) {
            foreach ($list as $item) {
                self::$_items[$item['id']] = $item['name'];
            }
        }

        return self::$_items;
    }

    // END Public methods


    // Protected methods

    // END Protected methods
}
