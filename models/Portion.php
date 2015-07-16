<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;
use yii\db\Query;
use yii\helpers\Html;

/**
 * This is the model class for table "portion".
 *
 * @property integer $id
 * @property integer $recipe_id
 * @property double $weight
 * @property string $name
 * @property string $description
 *
 * @property integer $recipeId
 * @property integer $calories
 * @property string $categoryName
 *
 * @property Diary[] $diaries
 * @property Recipe $recipe
 */
class Portion extends ModelAbstract
{
    protected $_calories;
    protected $_categoryName;
    protected $_ingredientString;

    public $recipeCategoryId;
    public $recipesItems;

    public static function tableName()
    {
        return 'portion';
    }

    public function rules()
    {
        return [
            [['weight', 'name'], 'required'],
            [['recipe_id', 'recipeId', 'recipeCategoryId'], 'integer'],
            [['weight', 'calories'], 'number'],
            [['description'], 'string'],
            [['name', 'categoryName'], 'string', 'max' => 255],
            [['recipesItems'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'name' => $this->t('Name'),
            'description' => $this->t('Description'),
            'recipeCategoryId' => $this->t('Category'),
            'calories' => $this->t('Calories'),
            'recipeId' => $this->t('Recipe'),
            'weight' => $this->t('Weight'),
            'recipesItems' => $this->t('Dish'),
            'categoryName' => $this->t('Category'),
            'ingredientString' => $this->t('Dish'),
        ];
    }

    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaries()
    {
        return $this->hasMany(Diary::className(), ['id' => 'diary_id'])->viaTable(Diary::diary2portionsTableName(), ['portion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }

    // END Depending


    // Event handlers

    // END Event handlers


    // Getters and setters

    /**
     * @param $value
     * @return $this
     */
    public function setCalories($value)
    {
        $this->_calories = $value;
        return $this;
    }

    public function getCalories()
    {
        if ($this->_calories !== null) {
            return $this->_calories;
        }

        $this->_calories = 0;

        if ($this->getIsNewRecord()) {
            return $this->_calories;
        }

        $calories = self::getCaloriesQuery($this->recipe_id)->one();
        if (!empty($calories)) {
            $this->_calories = $calories['calories']*$this->weight;
        }

        return $this->_calories;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setCategoryName($value)
    {
        $this->_categoryName = $value;
        return $this;
    }

    public function getCategoryName()
    {
        if ($this->_categoryName !== null) {
            return $this->_categoryName;
        }

        $this->_categoryName = '';

        if ($this->getIsNewRecord()) {
            return $this->_categoryName;
        }

        $category = self::getCategoryNameQuery($this->recipe_id)->one();
        if (!empty($category)) {
            $this->_categoryName = $category['name'];
        }

        return $this->_categoryName;
    }

    // END Getters and setters

    /**
     * @param $value
     * @return $this
     */
    public function setRecipeId($value)
    {
        $this->recipe_id = $value;
        return $this;
    }

    public function getRecipeId()
    {
        return $this->recipe_id;
    }

    // Public methods

    /**
     * @param $id
     * @return null|Portion
     */
    public static function findById($id)
    {
        $caloriesSql = self::getCaloriesQuery('`p`.`recipe_id`')->createCommand()->sql;

        return self::find()
            ->select([
                '`p`.*',
                "({$caloriesSql})*`p`.`weight` AS `calories`"
            ])
            ->from(self::tableName() . ' `p`')
            ->where(['id' => $id])
            ->one();
    }

    public function savePortion()
    {
        if (!$this->validate()) {
            return false;
        }

        if ($this->getIsNewRecord() && empty($this->recipesItems)) {
            $this->addError('recipesItems', $this->t('You have not select the dish'));
            return false;
        }

        $this->recipe_id = $this->recipesItems;

        return $this->save(false);
    }

    /**
     * @return bool
     */
    public function hasIngredient()
    {
        $this->recipesItems = $this->recipe_id;
        return !empty($this->recipesItems);
    }

    /**
     * @return array
     */
    public function getIngredientsCategoriesListItems()
    {
        return RecipeCategory::getItems();
    }

    /**
     * @return array
     */
    public function getIngredientsListItems()
    {
        return Recipe::getItems($this->recipeCategoryId);
    }

    public function getIngredientName()
    {
        return 'recipe';
    }

    public function getIngredientString()
    {
        if ($this->_ingredientString !== null) {
            return $this->_ingredientString;
        }

        $this->_ingredientString = '';

        $recipe = $this->recipe;
        if (!empty($recipe)) {
            $this->_ingredientString .=
                $this->weight . $this->t('gr.') .
                ' ' . Html::a($recipe->name, ['/recipe/view', 'id' => $recipe->id]) .
                ' (' . Yii::$app->view->round($recipe->calories) . $this->t('cc.') . ')';
        }

        return $this->_ingredientString;
    }

    /**
     * @param integer $id
     * @return Query
     */
    public static function getCaloriesQuery($id)
    {
        return (new Query())
            ->select('SUM(`prod`.`calories`*`rp`.`weight`)/SUM(`rp`.`weight`) AS `calories`')
            ->from(Recipe::recipe2productsTableName() . ' `rp`')
            ->leftJoin(Product::tableName() . ' `prod`', '`prod`.`id` = `rp`.`product_id`')
            ->where("`rp`.`recipe_id` = {$id}");
    }

    /**
     * @param integer $id
     * @return Query
     */
    public static function getCategoryNameQuery($id)
    {
        return (new Query())
            ->select('`c`.`name`')
            ->from(Recipe::tableName() . ' `r`')
            ->leftJoin(RecipeCategory::tableName() . ' `c`', '`c`.`id` = `r`.`category_id`')
            ->where("`r`.`id` = {$id}");
    }

    // END Public methods


    // Protected methods

    // END Protected methods
}
