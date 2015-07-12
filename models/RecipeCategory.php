<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;
use yii\db\Query;

/**
 * This is the model class for table "recipe_category".
 *
 * @property integer $id
 * @property string $name
 *
 * @property integer $recipesCount
 * @property integer $portionsCount
 *
 * @property Recipe[] $recipes
 */
class RecipeCategory extends ModelAbstract
{
    protected static $_items;

    protected $_recipesCount;
    protected $_portionsCount;

    public static function tableName()
    {
        return 'recipe_category';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['recipesCount', 'portionsCount'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'name' => $this->t('Name'),
            'recipesCount' => $this->t('Recipes count'),
            'portionsCount' => $this->t('Portions count'),
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

    /**
     * @param integer $value
     * @return $this
     */
    public function setRecipesCount($value)
    {
        $this->_recipesCount = $value;
        return $this;
    }

    public function getRecipesCount()
    {
        if ($this->_recipesCount !== null) {
            return $this->_recipesCount;
        }

        $this->_recipesCount = 0;

        if ($this->getIsNewRecord()) {
            return $this->_recipesCount;
        }

        $count = self::getRecipesCountQuery($this->id)->one();
        if (!empty($count)) {
            $this->_recipesCount = $count['recipesCount'];
        }

        return $this->_recipesCount;
    }

    /**
     * @param integer $value
     * @return $this
     */
    public function setPortionsCount($value)
    {
        $this->_portionsCount = $value;
        return $this;
    }

    public function getPortionsCount()
    {
        if ($this->_portionsCount !== null) {
            return $this->_portionsCount;
        }

        $this->_portionsCount = 0;

        if ($this->getIsNewRecord()) {
            return $this->_portionsCount;
        }

        $count = self::getPortionsCountQuery($this->id)->one();
        if (!empty($count)) {
            $this->_portionsCount = $count['portionsCount'];
        }

        return $this->_portionsCount;
    }

    // END Getters and setters


    // Public methods

    /**
     * @return array
     */
    public static function getItems()
    {
        if (self::$_items !== null) {
            return self::$_items;
        }

        self::$_items = [
            0 => '---'
        ];

        $list = self::find()
            ->orderBy('name')
            ->asArray()
            ->all();

        if (!empty($list)) {
            foreach ($list as $item) {
                self::$_items[$item['id']] = $item['name'];
            }
        }

        return self::$_items;
    }

    /**
     * @param integer|string $id
     * @return Query
     */
    public static function getRecipesCountQuery($id)
    {
        return (new Query())
            ->select('COUNT(*) AS `recipesCount`')
            ->from(Recipe::tableName() . ' `r`')
            ->where("`r`.`category_id` = {$id}");
    }

    /**
     * @param integer|string $id
     * @return Query
     */
    public static function getPortionsCountQuery($id)
    {
        //portionsCount
        return (new Query())
            ->select('COUNT(*) AS `portionsCount`')
            ->from(Portion::tableName() . ' `p`')
            ->leftJoin(Recipe::tableName() . ' `r`', '`r`.`id` = `p`.`recipe_id`')
            ->where("`r`.`category_id` = {$id}");
    }

    // END Public methods


    // Protected methods

    // END Protected methods
}
