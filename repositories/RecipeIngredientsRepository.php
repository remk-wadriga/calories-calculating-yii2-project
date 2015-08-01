<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 01.08.2015
 * Time: 15:04
 */

namespace app\repositories;

use Yii;
use yii\base\Model;
use app\models\Recipe;
use app\models\Product;
use yii\data\ArrayDataProvider;
use app\entities\IngredientEntity;

class RecipeIngredientsRepository extends IngredientEntity
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
     * @param array $params
     * @return ArrayDataProvider
     */
    public function search($params = [])
    {
        $query = IngredientEntity::find()
            ->select([
                '(\''.IngredientEntity::TYPE_WEIGHT.'\') AS type',
                'p.id',
                'p.name',
                'rp.weight',
                '`rp`.`weight` * `p`.`calories` AS calories',
            ])
            ->from(['rp' => Recipe::recipe2productsTableName()])
            ->leftJoin(['p' => Product::tableName()], 'p.id = rp.product_id')
            ->where(['rp.recipe_id' => $this->id])
            ->orderBy('calories DESC');

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query->all(),
            'sort' => [
                'attributes' => [
                    'name',
                    'weight',
                    'calories',
                ],
                'defaultOrder' => ['name' => SORT_ASC],
            ],
            'pagination' => false,
        ]);

        return $dataProvider;
    }
}