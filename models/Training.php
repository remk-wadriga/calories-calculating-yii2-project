<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "training".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property double $calories
 * @property string $description
 * @property integer $categoryId
 * @property string $categoryName
 *
 * @property ProductCategory $category
 */
class Training extends ModelAbstract
{
    public static function tableName()
    {
        return 'training';
    }

    public function rules()
    {
        return [
            [['category_id', 'name', 'calories'], 'required'],
            [['category_id', 'categoryId'], 'integer'],
            [['calories'], 'number'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'category_id' => $this->t('Category ID'),
            'categoryId' => $this->t('Category ID'),
            'categoryName' => $this->t('Category'),
            'name' => $this->t('Name'),
            'calories' => $this->t('Calories by h'),
            'description' => $this->t('Description'),
        ];
    }

    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(TrainingCategory::className(), ['id' => 'category_id'])->from(['c' => TrainingCategory::tableName()]);
    }

    // END Depending


    // Event handlers



    // END Event handlers


    // Getters and setters

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    // Getters and setters


    // Public methods

    public function getCategoryIdItems()
    {
        return TrainingCategory::getItems();
    }

    public function getCategoryName()
    {
        return $this->category->name;
    }

    // END Public methods


    // Protected methods

    // END Protected methods
}
