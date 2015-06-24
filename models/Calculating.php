<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "calculating".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date
 *
 *
 * @property integer $userId
 *
 * @property User $user
 * @property Portion[] $portions
 * @property Product[] $products
 * @property Recipe[] $recipes
 */
class Calculating extends ModelAbstract
{
    public static function tableName()
    {
        return 'calculating';
    }

    public function rules()
    {
        return [
            [['user_id', 'date'], 'required'],
            [['user_id', 'userId'], 'integer'],
            [['date'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'user_id' => $this->t('User ID'),
            'userId' => $this->t('User ID'),
            'date' => $this->t('Date'),
        ];
    }


    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('calculating_products', ['calculating_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortions()
    {
        return $this->hasMany(Portion::className(), ['id' => 'portion_id'])->viaTable('calculating_portions', ['calculating_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])->viaTable('calculating_recipes', ['calculating_id' => 'id']);
    }

    // END Depending


    // Event handlers

    public function beforeSave($insert)
    {
        if ($this->getIsNewRecord()) {
            if ($this->date === null) {
                $this->date = Yii::$app->timeService->getCurrentDate();
            }
        }

        return parent::beforeSave($insert);
    }

    // END Event handlers


    // Getters and setters

    /**
     * @param $value
     * @return $this
     */
    public function setUserId($value)
    {
        $this->user_id = $value;
        return $this;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    // END Getters and setters


    // Public methods

    // END Public methods


    // Protected methods

    // END Protected methods
}
