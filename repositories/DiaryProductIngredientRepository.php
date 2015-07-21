<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 21.07.2015
 * Time: 21:19
 */

namespace app\repositories;

use app\models\Product;
use Yii;
use app\models\Diary;
use app\entities\IngredientEntity;
use yii\data\ArrayDataProvider;

class DiaryProductIngredientRepository extends IngredientEntity
{
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
                '`dp`.`weight` * `p`.`calories` AS calories',
            ])
            ->from(['dp' => Diary::diary2productsTableName()])
            ->leftJoin(['p' => Product::tableName()], 'p.id = dp.product_id')
            ->where(['dp.diary_id' => $this->id])
            ->orderBy('calories DESC');

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query->all(),
            'sort' => false,
            'pagination' => false,
        ]);

        return $dataProvider;
    }
}