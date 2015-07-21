<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 21.07.2015
 * Time: 21:19
 */

namespace app\repositories;

use Yii;
use app\models\Diary;
use app\entities\IngredientEntity;
use yii\data\ArrayDataProvider;
use app\models\Portion;

class DiaryPortionIngredientRepository extends IngredientEntity
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
        $caloriesQuery = Portion::getCaloriesQuery('p.recipe_id')->createCommand()->sql;

        $query = IngredientEntity::find()
            ->select([
                '(\''.IngredientEntity::TYPE_COUNT.'\') AS type',
                'p.id',
                'p.name',
                'dp.count',
                "({$caloriesQuery}) * p.weight * dp.count AS calories",
            ])
            ->from(['dp' => Diary::diary2portionsTableName()])
            ->leftJoin(['p' => Portion::tableName()], 'p.id = dp.portion_id')
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