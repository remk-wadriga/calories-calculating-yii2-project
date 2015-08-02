<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $plan_id
 * @property string $name
 * @property string $description
 *
 * @property integer $planId
 *
 * @property Plan $plan
 * @property Portion[] $portions
 * @property Product[] $products
 * @property Recipe[] $recipes
 */
class Menu extends ModelAbstract
{
    public static function tableName()
    {
        return 'menu';
    }

    public static function menu2ProductTableName()
    {
        return 'menu_products';
    }

    public static function menu2RecipeTableName()
    {
        return 'menu_recipes';
    }

    public static function menu2PortionTableName()
    {
        return 'menu_portions';
    }

    public function rules()
    {
        return [
            [['plan_id'], 'integer'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'name' => $this->t('Name'),
            'description' => $this->t('Description'),
        ];
    }


    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable(self::menu2ProductTableName(), ['menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])->viaTable(self::menu2RecipeTableName(), ['menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortions()
    {
        return $this->hasMany(Portion::className(), ['id' => 'portion_id'])->viaTable(self::menu2PortionTableName(), ['menu_id' => 'id']);
    }

    // AND Depending


    // Event handlers

    // END Event handlers



    // Getters and setters

    /**
     * @param $val
     * @return $this
     */
    public function setPlanId($val)
    {
        $this->plan_id = $val;
        return $this;
    }

    public function getPlanId()
    {
        return $this->plan_id;
    }

    // END Getters and setters



    // Public functions

    // END Public functions
}
