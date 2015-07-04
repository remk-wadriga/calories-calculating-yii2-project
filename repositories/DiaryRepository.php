<?php

namespace app\repositories;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Diary;

/**
 * DiaryRepository represents the model behind the search form about `app\models\Diary`.
 */
class DiaryRepository extends Diary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
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
        $portionCaloriesSql = self::getPortionCaloriesQuery('`d`.`id`')->createCommand()->sql;
        $recipeCaloriesSql = self::getRecipeCaloriesQuery('`d`.`id`')->createCommand()->sql;
        $productCaloriesSql = self::getProductCaloriesQuery('`d`.`id`')->createCommand()->sql;

        $query = Diary::find()
            ->select([
                '`d`.*',
                "COALESCE(({$portionCaloriesSql}), 0) + COALESCE(({$recipeCaloriesSql}), 0) + COALESCE(({$productCaloriesSql}), 0) AS `calories`",
            ])
            ->from(self::tableName() . ' `d`')
            ->where(['`d`.`user_id`' => Yii::$app->user->id]);

        if (!isset($params['sort'])) {
            $query->orderBy('`d`.`date` DESC');
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
            '`d`.`date`' => $this->date,
        ]);

        $dataProvider->sort = [
            'attributes' => [
                'date',
                'calories',
            ],
        ];

        return $dataProvider;
    }
}
