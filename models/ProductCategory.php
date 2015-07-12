<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;
use yii\db\Query;

/**
 * This is the model class for table "product_category".
 *
 * @property integer $id
 * @property string $name
 *
 * @property integer $productsCount
 *
 * @property Product[] $products
 */
class ProductCategory extends ModelAbstract
{
    protected static $_items;

    protected $_productsCount;

    public static function tableName()
    {
        return 'product_category';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['productsCount'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'name' => $this->t('Name'),
            'productsCount' => $this->t('Products count'),
        ];
    }


    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    // END Depending


    // Event handlers

    // END Event handlers


    // Getters and setters

    /**
     * @param integer $value
     * @return $this
     */
    public function setProductsCount($value)
    {
        $this->_productsCount = $value;
        return $this;
    }

    public function getProductsCount()
    {
        if ($this->_productsCount !== null) {
            return $this->_productsCount;
        }

        $this->_productsCount = 0;

        if ($this->getIsNewRecord()) {
            return $this->_productsCount;
        }

        $count = self::getProductsCountQuery($this->id)->one();
        if (!empty($count)) {
            $this->_productsCount = $count['productsCount'];
        }

        return $this->_productsCount;
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

        self::$_items = [0 => '---'];

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
    public static function getProductsCountQuery($id)
    {
        return (new Query())
            ->select('COUNT(*) AS `productsCount`')
            ->from(Product::tableName())
            ->where("`category_id` = {$id}");
    }

    // END Public methods


    // Protected methods

    // END Protected methods
}
