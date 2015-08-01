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
use app\models\Diary;
use app\entities\IngredientEntity;
use yii\data\ArrayDataProvider;
use app\models\Recipe;

class DiaryRecipeIngredientRepository extends IngredientEntity
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
        $caloriesQuery = Recipe::getCaloriesQuery('dr.recipe_id')->createCommand()->sql;

        $query = IngredientEntity::find()
            ->select([
                '(\''.IngredientEntity::TYPE_WEIGHT.'\') AS type',
                'r.id',
                'r.name',
                'dr.weight',
                "({$caloriesQuery}) * dr.weight AS calories",
            ])
            ->from(['dr' => Diary::diary2recipesTableName()])
            ->leftJoin(['r' => Recipe::tableName()], 'r.id = dr.recipe_id')
            ->where(['dr.diary_id' => $this->id])
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