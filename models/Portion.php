<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "portion".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 *
 * @property Calculating[] $calculatings
 * @property Recipe[] $recipes
 */
class Portion extends ModelAbstract
{
    public $productCategoryId;
    public $productId;

    public static function tableName()
    {
        return 'portion';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['productCategoryId', 'productId'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'name' => $this->t('Name'),
            'description' => $this->t('Description'),
            'productCategoryId' => $this->t('Products category'),
            'productId' => $this->t('Product'),
        ];
    }


    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalculatings()
    {
        return $this->hasMany(Calculating::className(), ['id' => 'calculating_id'])->viaTable('calculating_portions', ['portion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])->viaTable('portion_recipes', ['portion_id' => 'id']);
    }

    // END Depending


    // Event handlers

    // END Event handlers


    // Getters and setters

    // END Getters and setters


    // Public methods

    /**
     * @return array
     */
    public function getProductCategoriesListItems()
    {
        return ProductCategory::getItems();
    }

    /**
     * @return array
     */
    public function getProductsListItems()
    {
        return Product::getItems($this->productCategoryId);
    }

    // END Public methods


    // Protected methods

    // END Protected methods
}
