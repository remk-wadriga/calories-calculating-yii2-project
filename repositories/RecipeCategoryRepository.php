<?php

namespace app\repositories;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecipeCategory;

/**
 * RecipeCategoryRepository represents the model behind the search form about `app\models\RecipeCategory`.
 */
class RecipeCategoryRepository extends RecipeCategory
{
    public $recipesCount;
    public $portionsCount;

    public function rules()
    {
        return [
            //[['recipesCount', 'portionsCount'], 'integer'],
            [['name'], 'safe'],
        ];
    }

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
        $recipesCountSql = self::getRecipesCountQuery('`rc`.`id`')->createCommand()->sql;
        $portionsCount = self::getPortionsCountQuery('`rc`.`id`')->createCommand()->sql;

        $query = RecipeCategory::find()
            ->select([
                '`rc`.*',
                "({$recipesCountSql}) AS `recipesCount`",
                "({$portionsCount}) AS `portionsCount`",
            ])
            ->from(RecipeCategory::tableName() . ' `rc`');

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
            //'recipesCount' => $this->recipesCount,
            //'portionsCount' => $this->portionsCount,
        ]);

        $query->andFilterWhere(['like', '`rc`.`name`', $this->name]);

        $dataProvider->sort = [
            'attributes' => [
                'name',
                'recipesCount',
                'portionsCount',
            ],
            'defaultOrder' => ['name' => SORT_ASC]
        ];

        return $dataProvider;
    }
}
