<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;
use app\repositories\PortionRepository;

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
 * @property string $categoryName
 *
 * @property Diary[] $diaries
 * @property Recipe $recipe
 */
class Portion extends ModelAbstract
{
    protected $_categoryName;

    public $recipeCategoryId;
    public $recipesItems;
    public $calories;
    public $proteins;
    public $fats;
    public $carbohydrates;
    public $recipeName;

    public static function tableName()
    {
        return 'portion';
    }

    public function rules()
    {
        return [
            [['weight', 'name'], 'required'],
            [['recipe_id', 'recipeId', 'recipeCategoryId'], 'integer'],
            [['weight', 'calories', 'proteins', 'fats', 'carbohydrates'], 'number'],
            [['description'], 'string'],
            [['name', 'recipeName', 'categoryName'], 'string', 'max' => 255],
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
            'proteins' => $this->t('Proteins'),
            'fats' => $this->t('Fats'),
            'carbohydrates' => $this->t('Carbohydrates'),
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
        return PortionRepository::searchOne($id);
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

    // END Public methods


    // Protected methods

    // END Protected methods
}
