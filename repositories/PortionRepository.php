<?php

namespace app\repositories;

use app\models\Product;
use app\models\Recipe;
use app\models\RecipeCategory;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Portion;

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
        $caloriesSql = self::getCaloriesQuery('`p`.`recipe_id`')->createCommand()->sql;

        $query = Portion::find()
            ->select([
                '`p`.*',
                "({$caloriesSql}) AS `calories`",
                '`c`.`name` AS `categoryName`'
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
        ]);

        $query->andFilterWhere(['like', '`p`.`name`', $this->name])
            ->andFilterWhere(['like', '`c`.`name`', $this->categoryName]);

        $dataProvider->sort = [
            'attributes' => [
                'name',
                'categoryName',
                'calories'
            ],
        ];

        return $dataProvider;
    }
}
