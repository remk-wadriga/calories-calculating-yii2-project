<?php
namespace app\repositories;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use app\models\Recipe;
use app\models\Product;
use app\models\RecipeCategory;
use app\traits\RepositoriesTrait;

/**
 * RecipeRepository represents the model behind the search form about `app\models\Recipe`.
 */
class RecipeRepository extends Recipe
{
    use RepositoriesTrait;

    public $categoryName;
    public $calories;

    public function rules()
    {
        return [
            [['id', 'category_id', 'categoryId'], 'integer'],
            [['name', 'categoryName'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param array|string|integer $params
     * @return Recipe
     */
    public static function searchOne($params)
    {
        $where = is_array($params) ? $params : ['r.id' => $params];

        return Recipe::find()
            ->select([
                'r.*',
                'categoryName' => 'c.name',
                'calories' => 'SUM(`rp`.`weight`*`p`.`calories`)/SUM(`rp`.`weight`)',
                'proteins' => 'SUM(`rp`.`weight`*`p`.`protein`)/SUM(`rp`.`weight`)',
                'fats' => 'SUM(`rp`.`weight`*`p`.`fat`)/SUM(`rp`.`weight`)',
                'carbohydrates' => 'SUM(`rp`.`weight`*`p`.`carbohydrate`)/SUM(`rp`.`weight`)'
            ])
            ->from(['r' => 'recipe'])
            ->innerJoin(['rp' => 'recipe_products'], '`rp`.`recipe_id` = `r`.`id`')
            ->leftJoin(['c' => 'recipe_category'], '`c`.`id` = `r`.`category_id`')
            ->leftJoin(['p' => 'product'], '`p`.`id` = `rp`.`product_id`')
            ->where($where)
            ->one();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->addParam('categoryId', $params);

        $caloriesSql = self::getCaloriesQuery('`r`.`id`')->createCommand()->sql;
        $proteinsSql = self::getProteinsQuery('`r`.`id`')->createCommand()->sql;
        $fatsSql = self::getFatsQuery('`r`.`id`')->createCommand()->sql;
        $carbohydratesSql = self::getCarbohydratesQuery('`r`.`id`')->createCommand()->sql;

        $query = Recipe::find()
            ->select([
                'r.*',
                'categoryName' => 'c.name',
                'calories' => "({$caloriesSql})",
                'proteins' => "({$proteinsSql})",
                'fats' => "({$fatsSql})",
                'carbohydrates' => "({$carbohydratesSql})",
            ])
            ->from(self::tableName() . ' `r`')
            ->leftJoin(RecipeCategory::tableName() . ' `c`', '`c`.`id` = `r`.`category_id`');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([

        ]);

        $query->andFilterWhere(['like', '`r`.`name`', $this->name])
            ->andFilterWhere(['like', '`r`.`description`', $this->description])
            ->andFilterWhere(['like', '`c`.`name`', $this->categoryName])
            ->andFilterWhere(['category_id' => $this->categoryId]);


        $dataProvider->sort = [
            'attributes' => [
                'name',
                'categoryName',
                'calories',
                'proteins',
                'fats',
                'carbohydrates'
            ],
        ];

        return $dataProvider;
    }

    /**
     * @param integer $id
     * @return Query
     */
    public static function getCaloriesQuery($id)
    {
        return (new Query())
            ->select('SUM(`rp`.`weight`*`p`.`calories`)/SUM(`rp`.`weight`) AS `calories`')
            ->from(['rp' => self::recipe2productsTableName()])
            ->leftJoin(Product::tableName() . ' `p`' , '`p`.`id` = `rp`.`product_id`')
            ->where("`rp`.`recipe_id` = {$id}");
    }

    /**
     * @param integer $id
     * @return Query
     */
    public static function getProteinsQuery($id)
    {
        return (new Query())
            ->select('SUM(`rp`.`weight`*`p`.`protein`)/SUM(`rp`.`weight`) AS `protein`')
            ->from(['rp' => self::recipe2productsTableName()])
            ->leftJoin(Product::tableName() . ' `p`' , '`p`.`id` = `rp`.`product_id`')
            ->where("`rp`.`recipe_id` = {$id}");
    }

    /**
     * @param integer $id
     * @return Query
     */
    public static function getFatsQuery($id)
    {
        return (new Query())
            ->select('SUM(`rp`.`weight`*`p`.`fat`)/SUM(`rp`.`weight`) AS `fat`')
            ->from(['rp' => self::recipe2productsTableName()])
            ->leftJoin(Product::tableName() . ' `p`' , '`p`.`id` = `rp`.`product_id`')
            ->where("`rp`.`recipe_id` = {$id}");
    }

    /**
     * @param integer $id
     * @return Query
     */
    public static function getCarbohydratesQuery($id)
    {
        return (new Query())
            ->select('SUM(`rp`.`weight`*`p`.`carbohydrate`)/SUM(`rp`.`weight`) AS `carbohydrate`')
            ->from(['rp' => self::recipe2productsTableName()])
            ->leftJoin(Product::tableName() . ' `p`' , '`p`.`id` = `rp`.`product_id`')
            ->where("`rp`.`recipe_id` = {$id}");
    }
}
