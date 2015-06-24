<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "recipe_category".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Recipe[] $recipes
 */
class RecipeCategory extends ModelAbstract
{
    public static function tableName()
    {
        return 'recipe_category';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['category_id' => 'id']);
    }

    // END Depending


    // Event handlers

    // END Event handlers


    // Getters and setters

    // END Getters and setters


    // Public methods

    // END Public methods


    // Protected methods

    // END Protected methods
}