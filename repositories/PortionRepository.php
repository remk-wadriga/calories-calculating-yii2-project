<?php

namespace app\repositories;

use Yii;
use yii\base\Model;
use app\models\Product;
use app\models\Recipe;
use app\models\RecipeCategory;
use yii\data\ActiveDataProvider;
use app\models\Portion;
use yii\db\Query;

/**
 * PortionRepository represents the model behind the search form about `app\models\Portion`.
 */
class PortionRepository extends Portion
{
    public $categoryName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'categoryName'], 'safe'],
            [['weight'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $caloriesSql = RecipeRepository::getCaloriesQuery('`p`.`recipe_id`')->createCommand()->sql;
        $proteinsSql = RecipeRepository::getProteinsQuery('`r`.`id`')->createCommand()->sql;
        $fatsSql = RecipeRepository::getFatsQuery('`r`.`id`')->createCommand()->sql;
        $carbohydratesSql = RecipeRepository::getCarbohydratesQuery('`r`.`id`')->createCommand()->sql;

        $query = Portion::find()
            ->select([
                '`p`.*',
                'calories' => "({$caloriesSql})*`p`.`weight`",
                'proteins' => "({$proteinsSql})*`p`.`weight`",
                'fats' => "({$fatsSql})*`p`.`weight`",
                'carbohydrates' => "({$carbohydratesSql})*`p`.`weight`",
                'categoryName' => 'c.name',
                'recipeCategoryId' => 'r.category_id',
            ])
            ->from(self::tableName() . ' `p`')
            ->leftJoin(Recipe::tableName() . ' `r`', '`r`.`id` = `p`.`recipe_id`')
            ->leftJoin(RecipeCategory::tableName() . ' `c`', '`c`.`id` = `r`.`category_id`');

        if (isset($params['categoryId'])) {
            $query->where(['`r`.`category_id`' => $params['categoryId']]);
            unset($params['categoryId']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            '`p`.`weight`' => $this->weight,
        ]);

        $query->andFilterWhere(['like', '`p`.`name`', $this->name])
            ->andFilterWhere(['like', '`c`.`name`', $this->categoryName]);

        $dataProvider->sort = [
            'attributes' => [
                'name',
                'categoryName',
                'calories',
                'weight',
                'proteins',
                'fats',
                'carbohydrates',
            ],
        ];

        return $dataProvider;
    }

    /**
     * @param array|string|integer $params
     * @return Portion
     */
    public static function searchOne($params)
    {
        $where = is_array($params) ? $params : ['p.id' => $params];

        return Portion::find()
            ->select([
                'p.*',
                'p.weight',
                'categoryName' => 'c.name',
                'recipeName' => 'r.name',
                'calories' => 'SUM(`rp`.`weight`*`prod`.`calories`)/SUM(`rp`.`weight`)*`p`.`weight`',
                'proteins' => 'SUM(`rp`.`weight`*`prod`.`protein`)/SUM(`rp`.`weight`)*`p`.`weight`',
                'fats' => 'SUM(`rp`.`weight`*`prod`.`fat`)/SUM(`rp`.`weight`)*`p`.`weight`',
                'carbohydrates' => 'SUM(`rp`.`weight`*`prod`.`carbohydrate`)/SUM(`rp`.`weight`)*`p`.`weight`',
            ])
            ->from(['p' => Portion::tableName()])
            ->innerJoin(['r' => Recipe::tableName()], '`r`.`id` = `p`.`recipe_id`')
            ->innerJoin(['rp' => Recipe::recipe2productsTableName()], '`rp`.`recipe_id` = `r`.`id`')
            ->leftJoin(['c' => RecipeCategory::tableName()], '`c`.`id` = `r`.`category_id`')
            ->leftJoin(['prod' => Product::tableName()], '`prod`.`id` = `rp`.`product_id`')
            ->where($where)
            ->one();
    }
}
