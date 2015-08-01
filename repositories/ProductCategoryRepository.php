<?php

namespace app\repositories;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductCategory;

/**
 * ProductCategoryRepository represents the model behind the search form about `app\models\ProductCategory`.
 */
class ProductCategoryRepository extends ProductCategory
{
    public $productsCount;

    public function rules()
    {
        return [
            //[['productsCount'], 'integer'],
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
        $productsCountSql = self::getProductsCountQuery('`pc`.`id`')->createCommand()->sql;

        $query = ProductCategory::find()
            ->select([
                '`pc`.*',
                "({$productsCountSql}) AS `productsCount`",
            ])
            ->from(ProductCategory::tableName() . ' `pc`');

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
            //'productsCount' => $this->productsCount,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        $dataProvider->sort = [
            'attributes' => [
                'name',
                'productsCount'
            ],
            'defaultOrder' => ['name' => SORT_ASC]
        ];

        return $dataProvider;
    }
}
