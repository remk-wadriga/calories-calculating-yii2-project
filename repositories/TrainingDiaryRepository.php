<?php

namespace app\repositories;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrainingDiary;

/**
 * TrainingDiaryRepository represents the model behind the search form about `app\models\TrainingDiary`.
 */
class TrainingDiaryRepository extends TrainingDiary
{
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    public function scenarios()
    {
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
        $query = TrainingDiary::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'date' => $this->date,
        ]);

        return $dataProvider;
    }
}
