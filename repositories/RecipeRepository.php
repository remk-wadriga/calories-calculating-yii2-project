<?php
namespace app\repositories;

use app\models\RecipeCategory;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recipe;

/**
 * RecipeRepository represents the model behind the search form about `app\models\Recipe`.
 */
class RecipeRepository extends Recipe
{
    public $categoryName;
    public $calories;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'categoryId'], 'integer'],
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
        if (isset($params['categoryId'])) {
            $modelName = $this->modelName();
            if (!isset($params[$modelName])) {
                $params[$modelName] = [];
            }
            $params[$modelName]['categoryId'] = $params['categoryId'];
            unset($params['categoryId']);
        }

        $caloriesSql = Recipe::getCaloriesQuery('`r`.`id`')->createCommand()->sql;

        $query = Recipe::find()
            ->select([
                '`r`.*',
                '`c`.`name` AS `categoryName`',
                "({$caloriesSql}) AS `calories`",
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
            ],
        ];

        return $dataProvider;
    }
}
