<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "training_category".
 *
 * @property integer $id
 * @property string $name
 */
class TrainingCategory extends ModelAbstract
{
    protected static $_items;

    public static function tableName()
    {
        return 'training_category';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'name' => $this->t('Name'),
        ];
    }

    // Depending

    // END Depending


    // Event handlers

    // END Event handlers


    // Getters and setters

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
