<?php

namespace app\repositories;

use app\models\ProductCategory;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductRepository represents the model behind the search form about `app\models\Product`.
 */
class ProductRepository extends Product
{
    public $categoryName;

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

        $query = Product::find()
            ->select(['`p`.*', '`pc`.`name` AS `categoryName`'])
            ->from(Product::tableName() . '`p`')
            ->leftJoin(ProductCategory::tableName() . ' `pc`', '`p`.`category_id` = `pc`.`id`');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!isset($params['sort'])) {
            $query->orderBy('`p`.`name`');
        }

        $query->andFilterWhere([
        ]);

        $query->andFilterWhere(['like', '`p`.`name`', $this->name])
            ->andFilterWhere(['like', '`pc`.`name`', $this->categoryName]);

        $dataProvider->sort = [
            'attributes' => [
                'name',
                'calories',
                'categoryName' => [
                    SORT_ASC => '`pc`.`name` ASC',
                    SORT_DESC => '`pc`.`name` DESC',
                ],
            ],
        ];

        return $dataProvider;
    }
}
