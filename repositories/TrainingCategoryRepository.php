<?php

namespace app\repositories;

use app\models\Training;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrainingCategory;

/**
 * TrainingCategoryRepository represents the model behind the search form about `app\models\TrainingCategory`.
 */
class TrainingCategoryRepository extends TrainingCategory
{
    public $trainingsCount;

    public function rules()
    {
        return [
            [['id'], 'integer'],
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
        $countQuery = Training::find()->select('COUNT(*)')->where('`category_id` = `c`.`id`')->createCommand()->sql;

        $query = TrainingCategory::find()
            ->from(['c' => self::tableName()])
            ->select([
                'c.*',
                'trainingsCount' => "({$countQuery})",
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'name',
                    'trainingsCount'
                ],
                'defaultOrder' => ['name' => SORT_ASC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([]);

        $query->andFilterWhere(['like', 'c.name', $this->name]);

        return $dataProvider;
    }
}
