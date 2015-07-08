<?php

namespace app\repositories;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WeekStats;

/**
 * WeekStatsRepository represents the model behind the search form about `app\models\WeekStats`.
 */
class WeekStatsRepository extends WeekStats
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['start_date', 'end_date', 'days_stats'], 'safe'],
            [['weight', 'calories', 'average_weight', 'average_calories', 'body_weight'], 'number'],
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
        $query = WeekStats::find();

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'weight' => $this->weight,
            'calories' => $this->calories,
            'average_weight' => $this->average_weight,
            'average_calories' => $this->average_calories,
            'body_weight' => $this->body_weight,
        ]);

        $query->andFilterWhere(['like', 'days_stats', $this->days_stats]);

        return $dataProvider;
    }
}
