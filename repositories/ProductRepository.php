<?php

namespace app\repositories;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductCategory;
use app\models\Product;
use app\traits\RepositoriesTrait;

/**
 * ProductRepository represents the model behind the search form about `app\models\Product`.
 */
class ProductRepository extends Product
{
    use RepositoriesTrait;

    public $categoryName;
    public $categoryId;

    public function rules()
    {
        return [
            [['id', 'category_id', 'categoryId'], 'integer'],
            [['calories', 'protein', 'fat', 'carbohydrate'], 'number'],
            [['name', 'categoryName'], 'safe'],
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
        $this->addParam('categoryId', $params);

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
            '`p`.`calories`' => $this->calories,
            '`p`.`protein`' => $this->protein,
            '`p`.`fat`' => $this->fat,
            '`p`.`carbohydrate`' => $this->carbohydrate,
            '`p`.`category_id`' => $this->categoryId,
            '`pc`.`name`' => $this->categoryName,
        ]);

        $query->andFilterWhere(['like', '`p`.`name`', $this->name])
            ->andFilterWhere(['like', '`pc`.`name`', $this->categoryName]);

        $dataProvider->sort = [
            'attributes' => [
                'name',
                'calories',
                'protein',
                'fat',
                'carbohydrate',
                'categoryName' => [
                    SORT_ASC => '`pc`.`name` ASC',
                    SORT_DESC => '`pc`.`name` DESC',
                ],
            ],
        ];

        return $dataProvider;
    }
}
