<?php

namespace app\repositories;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EnergyCoefficient;

/**
 * EnergyCoefficientRepository represents the model behind the search form about `app\models\EnergyCoefficient`.
 */
class EnergyCoefficientRepository extends EnergyCoefficient
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['type', 'value'], 'safe'],
            [['coefficient'], 'number'],
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
        $query = EnergyCoefficient::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'coefficient' => $this->coefficient,
        ]);

        $query
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
