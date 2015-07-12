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
    public $bodyWeight;

    public function rules()
    {
        return [
            [['startDate', 'endDate'], 'safe'],
            [['weight', 'calories', 'averageWeight', 'averageCalories', 'bodyWeight'], 'number'],
            [['weighingDay'], 'integer'],
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
        $query = WeekStats::find();

        if (!Yii::$app->request->isConsoleRequest) {
            $query->where(['user_id' => Yii::$app->user->id]);
        }

        if (!isset($params['sort'])) {
            $query->orderBy('end_date DESC, weighing_day');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'weight' => $this->weight,
            'calories' => $this->calories,
            'average_weight' => $this->averageWeight,
            'average_calories' => $this->averageCalories,
            'body_weight' => $this->bodyWeight,
            'weighing_day' => $this->weighingDay,
        ]);

        $dataProvider->sort = [
            'attributes' => [
                'startDate' => [
                    'asc' => ['start_date' => SORT_ASC],
                    'desc' => ['start_date' => SORT_DESC],
                ],
                'endDate' => [
                    'asc' => ['end_date' => SORT_ASC],
                    'desc' => ['end_date' => SORT_DESC],
                ],
                'calories',
                'averageCalories' => [
                    'asc' => ['average_calories' => SORT_ASC],
                    'desc' => ['average_calories' => SORT_DESC],
                ],
                'weighingDay' => [
                    'asc' => ['weighing_day' => SORT_ASC],
                    'desc' => ['weighing_day' => SORT_DESC],
                ],
                'bodyWeight' => [
                    'asc' => ['body_weight' => SORT_ASC],
                    'desc' => ['body_weight' => SORT_DESC],
                ],
            ],
        ];

        return $dataProvider;
    }
}
