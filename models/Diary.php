<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;
use yii\db\Query;

/**
 * This is the model class for table "calculating".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date
 *
 *
 * @property integer $userId
 * @property integer $portionCalories
 * @property integer $recipeCalories
 * @property integer $productCalories
 * @property integer $calories
 *
 * @property User $user
 * @property Portion[] $portions
 * @property Product[] $products
 * @property Recipe[] $recipes
 */
class Diary extends ModelAbstract
{
    public $portionCategoryId;
    public $recipeCategoryId;
    public $productCategoryId;

    public $portionsList;
    public $recipesList;
    public $productsList;

    protected $_portionItems;
    protected $_recipeItems;
    protected $_productItems;
    protected $_portionCalories;
    protected $_recipeCalories;
    protected $_productCalories;
    protected $_calories;
    protected $_portionIngredients;
    protected $_recipesIngredients;
    protected $_productIngredients;

    public static function tableName()
    {
        return 'diary';
    }

    public static function diary2productsTableName()
    {
        return 'diary_products';
    }

    public static function diary2recipesTableName()
    {
        return 'diary_recipes';
    }

    public static function diary2portionsTableName()
    {
        return 'diary_portions';
    }

    public function rules()
    {
        return [
            [['user_id', 'userId'], 'integer'],
            [['calories', 'portionCalories', 'recipeCalories', 'productCalories'], 'number'],
            [['date', 'portionsList', 'recipesList', 'productsList'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'user_id' => $this->t('User ID'),
            'userId' => $this->t('User ID'),
            'date' => $this->t('Date'),
            'portionsList' => $this->t('Portions'),
            'recipesList' => $this->t('Recipes'),
            'productsList' => $this->t('Products'),
            'portionCategoryId' => $this->t('Portion categories'),
            'recipeCategoryId' => $this->t('Recipe categories'),
            'productCategoryId' => $this->t('Product categories'),
        ];
    }

    public function init()
    {
        parent::init();
        //$this->date = Yii::$app->timeService->getCurrentDate();
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
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable(self::diary2productsTableName(), ['diary_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortions()
    {
        return $this->hasMany(Portion::className(), ['id' => 'portion_id'])->viaTable(self::diary2portionsTableName(), ['diary_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])->viaTable(self::diary2recipesTableName(), ['diary_id' => 'id']);
    }

    // END Depending


    // Event handlers

    public function beforeSave($insert)
    {
        if ($this->getIsNewRecord()) {
            if ($this->date === null) {
                $this->date = Yii::$app->timeService->getCurrentDate();
            }
            if ($this->user_id === null) {
                $this->user_id = Yii::$app->user->id;
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

    /**
     * @param $value
     * @return $this
     */
    public function setPortionCalories($value)
    {
        $this->_portionCalories = $value;
        return $this;
    }

    public function getPortionCalories()
    {
        if ($this->_portionCalories !== null) {
            return $this->_portionCalories;
        }

        $this->_portionCalories = 0;

        $calories = self::getPortionCaloriesQuery($this->id)->one();
        if (!empty($calories)) {
            $this->_portionCalories = $calories['portionCalories'];
        }

        return $this->_portionCalories;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setRecipeCalories($value)
    {
        $this->_recipeCalories = $value;
        return $this;
    }

    public function getRecipeCalories()
    {
        if ($this->_recipeCalories !== null) {
            return $this->_recipeCalories;
        }

        $this->_recipeCalories = 0;

        $calories = self::getRecipeCaloriesQuery($this->id)->one();
        if (!empty($calories)) {
            $this->_recipeCalories = $calories['recipeCalories'];
        }

        return $this->_recipeCalories;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setProductCalories($value)
    {
        $this->_productCalories = $value;
        return $this;
    }

    public function getProductCalories()
    {
        if ($this->_productCalories !== null) {
            return $this->_productCalories;
        }

        $this->_productCalories = 0;

        $calories = self::getProductCaloriesQuery($this->id)->one();
        if (!empty($calories)) {
            $this->_productCalories = $calories['productCalories'];
        }

        return $this->_productCalories;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setCalories($value)
    {
        $this->_calories = $value;
        return $this;
    }

    public function getCalories()
    {
        if ($this->_calories === null) {
            $this->_calories = $this->getPortionCalories() + $this->getRecipeCalories() + $this->getProductCalories();
        }

        return $this->_calories;
    }

    // END Getters and setters


    // Public methods

    public function diarySave()
    {
        if (!$this->validate()) {
            return false;
        }

        $db = Yii::$app->getDb();
        $transaction = $db->beginTransaction();

        if (!$this->getIsNewRecord()) {
            $db->createCommand()->delete(self::diary2portionsTableName(), ['diary_id' => $this->id])->execute();
            $db->createCommand()->delete(self::diary2recipesTableName(), ['diary_id' => $this->id])->execute();
            $db->createCommand()->delete(self::diary2productsTableName(), ['diary_id' => $this->id])->execute();
        }

        if (!$this->save(false)) {
            $transaction->rollBack();
            return false;
        }

        // Save the diary portions
        if (!empty($this->portionsList)) {
            $columns = [
                'diary_id',
                'portion_id',
                'count'
            ];
            $rows = [];

            foreach ($this->portionsList as $id => $count) {
                $rows[] = [
                    $this->id,
                    $id,
                    $count
                ];
            }

            $result = $db->createCommand()->batchInsert(self::diary2portionsTableName(), $columns, $rows)->execute();
            if (!$result) {
                $this->addError('portionsList', $this->t('Unable to save the ingredients'));
                $transaction->rollBack();
                return false;
            }
        }

        // Save the diary recipes
        if (!empty($this->recipesList)) {
            $columns = [
                'diary_id',
                'recipe_id',
                'weight'
            ];
            $rows = [];

            foreach ($this->recipesList as $id => $weight) {
                $rows[] = [
                    $this->id,
                    $id,
                    $weight
                ];
            }

            $result = $db->createCommand()->batchInsert(self::diary2recipesTableName(), $columns, $rows)->execute();
            if (!$result) {
                $this->addError('recipesList', $this->t('Unable to save the ingredients'));
                $transaction->rollBack();
                return false;
            }
        }

        // Save the diary products
        if (!empty($this->productsList)) {
            $columns = [
                'diary_id',
                'product_id',
                'weight'
            ];
            $rows = [];

            foreach ($this->productsList as $id => $weight) {
                $rows[] = [
                    $this->id,
                    $id,
                    $weight
                ];
            }

            $result = $db->createCommand()->batchInsert(self::diary2productsTableName(), $columns, $rows)->execute();
            if (!$result) {
                $this->addError('productsList', $this->t('Unable to save the ingredients'));
                $transaction->rollBack();
                return false;
            }
        }

        $transaction->commit();
        return true;
    }

    /**
     * @param $id
     * @return null|Diary
     */
    public static function findById($id)
    {
        $portionCaloriesSql = self::getPortionCaloriesQuery($id)->createCommand()->sql;
        $recipeCaloriesSql = self::getRecipeCaloriesQuery($id)->createCommand()->sql;
        $productCaloriesSql = self::getProductCaloriesQuery($id)->createCommand()->sql;

        return self::find()
            ->select([
                '`d`.*',
                "COALESCE(({$portionCaloriesSql}), 0) + COALESCE(({$recipeCaloriesSql}), 0) + COALESCE(({$productCaloriesSql}), 0) AS `calories`",
            ])
            ->from(self::tableName() . ' `d`')
            ->where(['`d`.`id`' => $id])
            ->one();
    }

    /**
     * @return array
     */
    public function getRecipeCategoriesItems()
    {
        return RecipeCategory::getItems();
    }

    /**
     * @return array
     */
    public function getProductCategoriesItems()
    {
        return ProductCategory::getItems();
    }

    /**
     * @return array
     */
    public function getPortionItems()
    {
        if ($this->_portionItems !== null) {
            return $this->_portionItems;
        }

        $this->_portionItems = [
            0 => '---'
        ];

        $query = Portion::find()
            ->select([
                '`p`.`id`',
                '`p`.`name`'
            ])
            ->from(Portion::tableName() . ' `p`')
            ->orderBy('`p`.`name`');

        if (!empty($this->portionCategoryId)) {
            $query
                ->leftJoin(Recipe::tableName() . ' `r`', '`r`.`id` = `p`.`recipe_id`')
                ->where(['`r`.`category_id`' => $this->portionCategoryId]);
        }

        $items = $query->asArray()->all();
        if (!empty($items)) {
            foreach ($items as $item) {
                $this->_portionItems[$item['id']] = $item['name'];
            }
        }

        return $this->_portionItems;
    }

    /**
     * @return array
     */
    public function getRecipeItems()
    {
        if ($this->_recipeItems !== null) {
            return $this->_recipeItems;
        }

        $this->_recipeItems = [
            0 => '---'
        ];

        $query = Recipe::find()->orderBy('name');

        if (!empty($this->recipeCategoryId)) {
            $query->where(['category_id' => $this->recipeCategoryId]);
        }

        $items = $query->asArray()->all();
        if (!empty($items)) {
            foreach ($items as $item) {
                $this->_recipeItems[$item['id']] = $item['name'];
            }
        }

        return $this->_recipeItems;
    }

    /**
     * @return array
     */
    public function getProductItems()
    {
        if ($this->_productItems !== null) {
            return $this->_productItems;
        }

        $this->_productItems = [
            0 => '---',
        ];

        $query = Product::find()->orderBy('name');

        if (!empty($this->productCategoryId)) {
            $query->where(['category_id' => $this->productCategoryId]);
        }

        $items = $query->asArray()->all();
        if (!empty($items)) {
            foreach ($items as $item) {
                $this->_productItems[$item['id']] = $item['name'];
            }
        }

        return $this->_productItems;
    }

    /**
     * @return array
     */
    public function getPortionIngredients()
    {
        if ($this->_portionIngredients !== null) {
            return $this->_portionIngredients;
        }

        $this->_portionIngredients = [];

        $caloriesSql = (new Query())
            ->select('SUM(`prod`.`calories`*`rp`.`weight`)/SUM(`rp`.`weight`)')
            ->from(Recipe::recipe2productsTableName() . ' `rp`')
            ->leftJoin(Product::tableName() . ' `prod`', '`prod`.`id` = `rp`.`product_id`')
            ->where('`rp`.`recipe_id` = `p`.`recipe_id`')
            ->createCommand()
            ->sql;

        /**
         *    SELECT
         *       `p`.`id` AS `id`,
         *       `p`.`name` AS `name`,
         *       `dp`.`count` AS `count`,
         *       `dp`.`count`*`p`.`weight`*(
         *           SELECT
         *               SUM(`prod`.`calories`*`rp`.`weight`)/SUM(`rp`.`weight`)
         *           FROM `recipe_products` `rp`
         *           LEFT JOIN `product` `prod` ON `prod`.`id` = `rp`.`product_id`
         *           WHERE `rp`.`recipe_id` = `p`.`recipe_id`
         *       ) AS `calories`,
         *       `dp`.`count`*`p`.`weight` AS `weight`
         *   FROM `diary_portions` `dp`
         *   LEFT JOIN `portion` `p` ON `p`.`id` = `dp`.`portion_id`
         *   WHERE `dp`.`diary_id` = 1
         */
        $ingredients = (new Query())
            ->select([
                '`p`.`id` AS `id`',
                '`p`.`name` AS `name`',
                '`dp`.`count` AS `count`',
                "`dp`.`count`*`p`.`weight`*({$caloriesSql}) AS `calories`",
                '`dp`.`count`*`p`.`weight` AS `weight`'
            ])
            ->from(self::diary2portionsTableName() . ' `dp`')
            ->leftJoin(Portion::tableName() . ' `p`', '`p`.`id` = `dp`.`portion_id`')
            ->where(['`dp`.`diary_id`' => $this->id])
            ->all();

        if (!empty($ingredients)) {
            $this->_portionIngredients = $ingredients;
        }

        return $this->_portionIngredients;
    }

    /**
     * @return array
     */
    public function getRecipeIngredients()
    {
        if ($this->_recipesIngredients !== null) {
            return $this->_recipesIngredients;
        }

        $this->_recipesIngredients = [];

        $caloriesSql = (new Query())
            ->select('SUM(`prod`.`calories`*`rp`.`weight`)/SUM(`rp`.`weight`)')
            ->from(Recipe::recipe2productsTableName() . ' `rp`')
            ->leftJoin(Product::tableName() . ' `prod`', '`prod`.`id` = `rp`.`product_id`')
            ->where('`rp`.`recipe_id` = `dr`.`recipe_id`')
            ->createCommand()
            ->sql;

        /**
        *    SELECT
        *        `r`.`id` AS `id`,
        *        `r`.`name` AS `name`,
        *        `dr`.`weight`*(
        *            SELECT
        *                SUM(`prod`.`calories`*`rp`.`weight`)/SUM(`rp`.`weight`)
        *            FROM `recipe_products` `rp`
        *            LEFT JOIN `product` `prod` ON `prod`.`id` = `rp`.`product_id`
        *            WHERE `rp`.`recipe_id` = `dr`.`recipe_id`
        *        ) AS `calories`,
        *        `dr`.`weight` AS `weight`
        *    FROM `diary_recipes` `dr`
        *    LEFT JOIN `recipe` `r` ON `r`.`id` = `dr`.`recipe_id`
        *    WHERE `dr`.`diary_id` = 1
        */
        $ingredients = (new Query())
            ->select([
                '`r`.`id` AS `id`',
                '`r`.`name` AS `name`',
                "`dr`.`weight`*({$caloriesSql}) AS `calories`",
                '`dr`.`weight` AS `weight`'
            ])
            ->from(self::diary2recipesTableName() . ' `dr`')
            ->leftJoin(Recipe::tableName() . ' `r`', '`r`.`id` = `dr`.`recipe_id`')
            ->where(['`dr`.`diary_id`' => $this->id])
            ->all();

        if (!empty($ingredients)) {
            $this->_recipesIngredients = $ingredients;
        }

        return $this->_recipesIngredients;
    }

    /**
     * @return array
     */
    public function getProductIngredients()
    {
        if ($this->_productIngredients !== null) {
            return $this->_productIngredients;
        }

        $this->_productIngredients = [];

        /**
        *    SELECT
        *        `p`.`id` AS `id`,
        *        `p`.`name` AS `name`,
        *        `dp`.`weight`*`p`.`calories` AS `calories`,
        *        `dp`.`weight` AS `weight`
        *    FROM `diary_products` `dp`
        *    LEFT JOIN `product` `p` ON `p`.`id` = `dp`.`product_id`
        *    WHERE `dp`.`diary_id` = 1
        */
        $ingredients = (new Query())
            ->select([
                '`p`.`id` AS `id`',
                '`p`.`name` AS `name`',
                '`dp`.`weight`*`p`.`calories` AS `calories`',
                '`dp`.`weight` AS `weight`'
            ])
            ->from(self::diary2productsTableName() . ' `dp`')
            ->leftJoin(Product::tableName() . ' `p`', '`p`.`id` = `dp`.`product_id`')
            ->where(['`dp`.`diary_id`' => $this->id])
            ->all();

        if (!empty($ingredients)) {
            $this->_productIngredients = $ingredients;
        }

        return $this->_productIngredients;
    }

    /**
     * @param integer $id
     * @return Query
     */
    public static function getPortionCaloriesQuery($id)
    {
        $productCaloriesSql = (new Query())
            ->select('SUM(`prod`.`calories`*`rp`.`weight`)/SUM(`rp`.`weight`)')
            ->from(Recipe::recipe2productsTableName() . ' `rp`')
            ->leftJoin(Product::tableName() . ' `prod`', '`prod`.`id` = `rp`.`product_id`')
            ->where('`rp`.`recipe_id` = `p`.`recipe_id`')
            ->createCommand()
            ->sql;

        $portionCaloriesSql = (new Query())
            ->select("SUM(`p`.`weight`*COALESCE(({$productCaloriesSql}),0))")
            ->from(Portion::tableName() . ' `p`')
            ->where('`p`.`id` = `dp`.`portion_id`')
            ->createCommand()
            ->sql;

        $portionCaloriesSql = str_replace('`0))`', '0))', $portionCaloriesSql);

        /**
         * SELECT
         *     SUM(`dp`.`count` * (
         *        SELECT
         *            SUM(`p`.`weight` * COALESCE((
         *                SELECT
         *                    SUM(`prod`.`calories`*`rp`.`weight`)/SUM(`rp`.`weight`)
         *                FROM `recipe_products` `rp`
         *                LEFT JOIN `product` `prod` ON `prod`.`id` = `rp`.`product_id`
         *                WHERE `rp`.`recipe_id` = `p`.`recipe_id`
         *            ), 0))
         *        FROM `portion` `p`
         *        WHERE `p`.`id` = `dp`.`portion_id`
         *    ))
         * FROM `diary_portions` `dp`
         * WHERE `dp`.`diary_id` = `d`.`id`
         */
        return (new Query())
            ->select("SUM(`dp`.`count`*({$portionCaloriesSql})) AS `portionCalories`")
            ->from(Diary::diary2portionsTableName() . ' `dp`')
            ->where("`dp`.`diary_id` = {$id}");
    }

    /**
     * @param integer $id
     * @return Query
     */
    public static function getRecipeCaloriesQuery($id)
    {
        /**
         * SELECT
         * 	SUM(`dr`.`weight` * COALESCE((
         *        SELECT
         * 			SUM(`prod`.`calories`*`rp`.`weight`)/SUM(`rp`.`weight`)
         * 		FROM `recipe_products` `rp`
         * 		LEFT JOIN `product` `prod` ON `prod`.`id` = `rp`.`product_id`
         * 		WHERE `rp`.`recipe_id` = `dr`.`recipe_id`
         * 	), 0))
         * FROM `diary_recipes` `dr`
         * WHERE `dr`.`diary_id` = `d`.`id`
        */

        $productCaloriesSql = (new Query())
            ->select('SUM(`prod`.`calories`*`rp`.`weight`)/SUM(`rp`.`weight`)')
            ->from(Recipe::recipe2productsTableName() . ' `rp`')
            ->leftJoin(Product::tableName() . ' `prod`', '`prod`.`id` = `rp`.`product_id`')
            ->where('`rp`.`recipe_id` = `dr`.`recipe_id`')
            ->createCommand()
            ->sql;

        return (new Query())
            ->select("SUM(`dr`.`weight`*COALESCE(({$productCaloriesSql}),0)) AS `recipeCalories`")
            ->from(Diary::diary2recipesTableName() . ' `dr`')
            ->where("`dr`.`diary_id` = {$id}");
    }

    /**
     * @param integer $id
     * @return Query
     */
    public static function getProductCaloriesQuery($id)
    {
        /**
         * SELECT
         *   SUM(`prod`.`calories`*`dp`.`weight`)
         * FROM `diary_products` `dp`
         * LEFT JOIN `product` `prod` ON `prod`.`id` = `dp`.`product_id`
         * WHERE `dp`.`diary_id` = `d`.`id`
        */
        return (new Query())
            ->select('SUM(`prod`.`calories`*`dp`.`weight`) AS `productCalories`')
            ->from(Diary::diary2productsTableName() . ' `dp`')
            ->leftJoin(Product::tableName() . ' `prod`', '`prod`.`id` = `dp`.`product_id`')
            ->where("`dp`.`diary_id` = {$id}");
    }

    // END Public methods


    // Protected methods

    // END Protected methods
}
