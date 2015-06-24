<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "recipe".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $description
 *
 *
 * @property integer $categoryId
 *
 * @property Calculating[] $calculatings
 * @property Portion[] $portions
 * @property RecipeCategory $category
 * @property Product[] $products
 */
class Recipe extends ModelAbstract
{
    public static function tableName()
    {
        return 'recipe';
    }

    public function rules()
    {
        return [
            [['category_id', 'name'], 'required'],
            [['category_id', 'categoryId'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'category_id' => $this->t('Category ID'),
            'name' => $this->t('Name'),
            'description' => $this->t('Description'),
        ];
    }

    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalculatings()
    {
        return $this->hasMany(Calculating::className(), ['id' => 'calculating_id'])->viaTable('calculating_recipes', ['recipe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortions()
    {
        return $this->hasMany(Portion::className(), ['id' => 'portion_id'])->viaTable('portion_recipes', ['recipe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(RecipeCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('recipe_products', ['recipe_id' => 'id']);
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
