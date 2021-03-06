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
 * @property double $protein
 * @property double $fat
 * @property double $carbohydrate
 *
 *
 * @property integer $categoryId
 * @property string $categoryName
 *
 * @property Diary[] $diaries
 * @property ProductCategory $category
 * @property Recipe[] $recipes
 */
class Product extends ModelAbstract
{
    protected static $_items;

    protected $_categoryIdItems;
    protected $_categoryName;

    public static function tableName()
    {
        return 'product';
    }

    public function rules()
    {
        return [
            [['name', 'calories'], 'required'],
            [['category_id', 'categoryId'], 'integer'],
            [['calories', 'protein', 'fat', 'carbohydrate'], 'number'],
            [['description', 'categoryName'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'category_id' => $this->t('Category ID'),
            'categoryId' => $this->t('Category'),
            'name' => $this->t('Name'),
            'calories' => $this->t('Calories (by 100 gr.)'),
            'description' => $this->t('Description'),
            'categoryName' => $this->t('Category'),
            'protein' => $this->t('Proteins (by 100 gr.)'),
            'fat' => $this->t('Fats (by 100 gr.)'),
            'carbohydrate' => $this->t('Carbohydrates (by 100 gr.)'),
        ];
    }

    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaries()
    {
        return $this->hasMany(Diary::className(), ['id' => 'diary_id'])->viaTable(Diary::diary2productsTableName(), ['product_id' => 'id']);
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
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])->viaTable(Recipe::recipe2productsTableName(), ['product_id' => 'id']);
    }

    // END Depending


    // Event handlers

    public function beforeSave($insert)
    {
        if ($this->calories > 0) {
            $this->calories = $this->calories/100;
        }
        if ($this->protein > 0) {
            $this->protein = $this->protein/100;
        }
        if ($this->fat > 0) {
            $this->fat = $this->fat/100;
        }
        if ($this->carbohydrate > 0) {
            $this->carbohydrate = $this->carbohydrate/100;
        }

        return parent::beforeSave($insert);
    }

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

    public function setCategoryName($value)
    {
        $this->_categoryName = $value;
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

    /**
     * @param $id
     * @return Product
     */
    public static function findById($id)
    {
        return self::find()
            ->select(['`p`.*', '`pc`.`name` AS `categoryName`'])
            ->from(self::tableName() . ' `p`')
            ->leftJoin(ProductCategory::tableName() . ' `pc`', '`pc`.`id` = `p`.`category_id`')
            ->where(['`p`.`id`' => $id])
            ->one();
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

        $categories = ProductCategory::find()
            ->orderBy('name')
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

    // END Public methods


    // Protected methods

    // END Protected methods
}
