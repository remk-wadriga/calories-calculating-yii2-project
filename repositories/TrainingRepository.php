<?php

namespace app\repositories;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Training;

/**
 * TrainingRepository represents the model behind the search form about `app\models\Training`.
 */
class TrainingRepository extends Training
{
    public $categoryName;
    public $categoryId;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'description', 'categoryName', 'categoryId'], 'safe'],
            [['calories'], 'number'],
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
        if (isset($params['categoryId'])) {
            $modelName = $this->modelName();
            if (!isset($params[$modelName])) {
                $params[$modelName] = [];
            }
            $params[$modelName]['categoryId'] = $params['categoryId'];
            unset($params['categoryId']);
        }

        $query = Training::find()
            ->from(['t' => self::tableName()])
            ->joinWith('category');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'name',
                    'calories',
                    'categoryName' => [
                        'asc' => [
                            'c.name' => SORT_ASC,
                        ],
                        'desc' => [
                            'c.name' => SORT_DESC,
                        ],
                    ],
                ],
                'defaultOrder' => ['name' => SORT_ASC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            't.id' => $this->id,
            't.calories' => $this->calories,
            't.category_id' => $this->categoryId,
        ]);

        $query
            ->andFilterWhere(['like', 't.name', $this->name])
            ->andFilterWhere(['like', 't.description', $this->description])
            ->andFilterWhere(['like', 'c.name', $this->categoryName]);

        return $dataProvider;
    }
}