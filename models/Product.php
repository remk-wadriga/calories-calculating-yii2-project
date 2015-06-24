<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property double $calories
 * @property string $description
 *
 *
 * @property integer $categoryId
 *
 * @property Calculating[] $calculatings
 * @property ProductCategory $category
 * @property Recipe[] $recipes
 */
class Product extends ModelAbstract
{
    public static function tableName()
    {
        return 'product';
    }

    public function rules()
    {
        return [
            [['name', 'calories'], 'required'],
            [['category_id', 'categoryId'], 'integer'],
            [['calories'], 'number'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'category_id' => $this->t('Category ID'),
            'categoryId' => $this->t('Category ID'),
            'name' => $this->t('Name'),
            'calories' => $this->t('Calories'),
            'description' => $this->t('Description'),
        ];
    }

    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalculatings()
    {
        return $this->hasMany(Calculating::className(), ['id' => 'calculating_id'])->viaTable('calculating_products', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])->viaTable('recipe_products', ['product_id' => 'id']);
    }

    // END Depending


    // Event handlers

    // END Event handlers


    // Getters and setters

    /**
     * @param $value
     * @return $this
     */
    public function setCategoryId($value)
    {
        $this->category_id = $value;
        return $this;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    // END Getters and setters


    // Public methods

    // END Public methods


    // Protected methods

    // END Protected methods
}
