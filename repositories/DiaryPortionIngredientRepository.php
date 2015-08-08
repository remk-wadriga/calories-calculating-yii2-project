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
use app\models\Portion;

class DiaryPortionIngredientRepository extends IngredientEntity
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
        $caloriesQuery = RecipeRepository::getCaloriesQuery('p.recipe_id')->createCommand()->sql;
        $proteinsQuery = RecipeRepository::getProteinsQuery('p.recipe_id')->createCommand()->sql;
        $fatsQuery = RecipeRepository::getFatsQuery('p.recipe_id')->createCommand()->sql;
        $carbohydratesQuery = RecipeRepository::getCarbohydratesQuery('p.recipe_id')->createCommand()->sql;

        $query = IngredientEntity::find()
            ->select([
                '(\''.IngredientEntity::TYPE_COUNT.'\') AS type',
                'p.id',
                'p.name',
                'dp.count',
                "({$caloriesQuery}) * p.weight * dp.count AS calories",
                "({$proteinsQuery}) * `p`.`weight` AS `protein`",
                "({$fatsQuery}) * `p`.`weight` AS `fat`",
                "({$carbohydratesQuery}) * `p`.`weight` AS `carbohydrate`",
            ])
            ->from(['dp' => Diary::diary2portionsTableName()])
            ->leftJoin(['p' => Portion::tableName()], 'p.id = dp.portion_id')
            ->where(['dp.diary_id' => $this->id])
            ->orderBy('calories DESC');

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query->all(),
            'sort' => [
                'attributes' => [
                    'name',
                    'count',
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