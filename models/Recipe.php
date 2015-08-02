<?php

namespace app\models;

use app\repositories\RecipeRepository;
use Yii;
use app\abstracts\ModelAbstract;
use yii\db\Query;
use yii\helpers\Html;

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
 * @property string $categoryName
 * @property integer $calories
 *
 * @property Diary[] $diary
 * @property Portion[] $portions
 * @property RecipeCategory $category
 * @property Product[] $products
 */
class Recipe extends ModelAbstract
{
    protected static $_items;

    protected $_categoryIdItems;
    protected $_categoryName;
    protected $_productsInfo;
    protected $_ingredients;
    protected $_productsListString;

    public $productCategoryId;
    public $productsItems;
    public $calories;
    public $proteins;
    public $fats;
    public $carbohydrates;

    public static function tableName()
    {
        return 'recipe';
    }

    public static function recipe2productsTableName()
    {
        return 'recipe_products';
    }

    public function rules()
    {
        return [
            [['category_id', 'name'], 'required'],
            [['category_id', 'categoryId'], 'integer'],
            [['description'], 'string'],
            [['calories', 'proteins', 'fats', 'carbohydrates'], 'number'],
            [['name', 'categoryName'], 'string', 'max' => 255],
            [['productsItems'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'category_id' => $this->t('Category ID'),
            'name' => $this->t('Name'),
            'description' => $this->t('Description'),
            'categoryId' => $this->t('Category'),
            'productCategoryId' => $this->t('Products category'),
            'productsItems' => $this->t('Product'),
            'categoryName' => $this->t('Category'),
            'calories' => $this->t('Calories (by 100 gr.)'),
            'productsListString' => $this->t('Ingredients'),
            'proteins' => $this->t('Proteins (by 100 gr.)'),
            'fats' => $this->t('Fats (by 100 gr.)'),
            'carbohydrates' => $this->t('Carbohydrates (by 100 gr.)'),
        ];
    }

    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiary()
    {
        return $this->hasMany(Diary::className(), ['id' => 'calculating_id'])->viaTable(Diary::diary2recipesTableName(), ['recipe_id' => 'id']);
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
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable(self::recipe2productsTableName(), ['recipe_id' => 'id']);
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

    /**
     * @param string $value
     * @return $this
     */
    public function setCategoryName($value)
    {
        $this->_categoryName = trim($value);
        return $this;
    }

    public function getCategoryName()
    {
        if ($this->_categoryName !== null) {
            return $this->_categoryName;
        }

        $this->_categoryName = '';

        $category = $this->category;
        if (!empty($category)) {
            $this->_categoryName = $category->name;
        }

        return $this->_categoryName;
    }

    // END Getters and setters


    // Public methods

    public function saveRecipe()
    {
        if (!$this->validate()) {
            return false;
        }

        $db = Yii::$app->getDb();
        $transaction = $db->beginTransaction();

        if (!$this->getIsNewRecord()) {
            $db->createCommand()->delete(self::recipe2productsTableName(), ['recipe_id' => $this->id])->execute();
        } elseif (empty($this->productsItems)) {
            $this->addError('productsItems', $this->t('You have not added any ingredient'));
            return false;
        }

        if (!$this->save(false)) {
            $transaction->rollBack();
            return false;
        }

        if (!empty($this->productsItems)) {
            $columns = [
                'recipe_id',
                'product_id',
                'weight'
            ];
            $rows = [];

            foreach ($this->productsItems as $id => $weight) {
                $rows[] = [
                    $this->id,
                    $id,
                    $weight
                ];
            }

            $result = $db->createCommand()->batchInsert(self::recipe2productsTableName(), $columns, $rows)->execute();
            if (!$result) {
                $this->addError('productsItems', $this->t('Unable to save the ingredients'));
                $transaction->rollBack();
                return false;
            }
        }

        $transaction->commit();
        return true;
    }

    /**
     * @return array
     */
    public function getCategoryIdItems()
    {
        if ($this->_categoryIdItems !== null) {
            return $this->_categoryIdItems;
        }

        $this->_categoryIdItems = [];

        $categories = RecipeCategory::find()
            ->orderBy('id')
            ->asArray()
            ->all();

        if (!empty($categories)) {
            foreach ($categories as $category) {
                $this->_categoryIdItems[$category['id']] = $category['name'];
            }
        }

        return $this->_categoryIdItems;
    }

    /**
     * @return array
     */
    public function getIngredientsCategoriesListItems()
    {
        return ProductCategory::getItems();
    }

    /**
     * @return array
     */
    public function getIngredientsListItems()
    {
        return Product::getItems($this->productCategoryId);
    }

    /**
     * @return string
     */
    public function getProductsListString()
    {
        if ($this->_productsListString !== null) {
            return $this->_productsListString;
        }

        $this->_productsListString = '';

        $ingredients = $this->getIngredients();
        if (!empty($ingredients)) {
            $string = '';
            foreach ($ingredients as $ingredient) {
                $string .= $ingredient['weight'] . $this->t('gr.');
                $string .= ' ';
                $string .= Html::a($ingredient['name'], ['/product/view', 'id' => $ingredient['id']]);
                $string .= ' (' . $ingredient['calories'] . $this->t('cc.') . '), ';
            }

            $this->_productsListString = substr($string, 0, strlen($string) - 2);
        }

        return $this->_productsListString;
    }

    /**
     * @return array
     */
    public function getIngredients()
    {
        if ($this->_ingredients !== null) {
            return $this->_ingredients;
        }

        $this->_ingredients = [];

        $items = (new Query())
            ->select([
                '`p`.`id` AS `id`',
                '`p`.`name` AS `name`',
                '`rp`.`weight` AS `weight`',
                '`p`.`calories` AS `calories`'
            ])
            ->from(self::recipe2productsTableName() . ' `rp`')
            ->leftJoin(Product::tableName() . ' `p`', '`p`.`id` = `rp`.`product_id`')
            ->where(['`rp`.`recipe_id`' => $this->id])
            ->all();

        if (!empty($items)) {
            $this->_ingredients = $items;
        }

        return $this->_ingredients;
    }

    /**
     * @param integer $id
     * @return Recipe|bool
     */
    public static function findById($id)
    {
        return RecipeRepository::searchOne($id);
    }

    /**
     * @param null|integer $categoryId
     * @return array
     */
    public static function getItems($categoryId = null)
    {
        if (self::$_items !== null) {
            return self::$_items;
        }

        self::$_items = [0 => '---'];

        $query = self::find()
            ->orderBy('name')
            ->asArray();

        if ($categoryId !== null) {
            $query->where(['category_id' => $categoryId]);
        }

        $list = $query->all();
        if (!empty($list)) {
            foreach ($list as $item) {
                self::$_items[$item['id']] = $item['name'];
            }
        }

        return self::$_items;
    }

    public function getIngredientName()
    {
        return 'product';
    }

    // END Public methods


    // Protected methods

    // END Protected methods
}
