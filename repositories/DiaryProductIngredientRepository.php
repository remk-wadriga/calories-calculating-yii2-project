<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 21.07.2015
 * Time: 21:19
 */

namespace app\repositories;

use Yii;
use yii\base\Model;
use app\models\Product;
use app\models\Diary;
use app\entities\IngredientEntity;
use yii\data\ArrayDataProvider;

class DiaryProductIngredientRepository extends IngredientEntity
{
    public function rules()
    {
        return [];
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
     * @return ArrayDataProvider
     */
    public function search($params = [])
    {
        $query = IngredientEntity::find()
            ->select([
                '(\''.IngredientEntity::TYPE_WEIGHT.'\') AS type',
                'p.id',
                'p.name',
                'dp.weight',
                '`dp`.`weight` * `p`.`calories` AS `calories`',
                '`dp`.`weight` * `p`.`protein` AS `protein`',
                '`dp`.`weight` * `p`.`fat` AS `fat`',
                '`dp`.`weight` * `p`.`carbohydrate` AS `carbohydrate`',
            ])
            ->from(['dp' => Diary::diary2productsTableName()])
            ->leftJoin(['p' => Product::tableName()], 'p.id = dp.product_id')
            ->where(['dp.diary_id' => $this->id])
            ->orderBy('calories DESC');

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query->all(),
            'sort' => [
                'attributes' => [
                    'name',
                    'weight',
                    'calories',
                    'protein',
                    'fat',
                    'carbohydrate',
                ],
                'defaultOrder' => ['name' => SORT_ASC],
            ],
            'pagination' => false,
        ]);

        return $dataProvider;
    }
}