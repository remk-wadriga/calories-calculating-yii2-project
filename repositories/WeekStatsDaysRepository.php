<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 01.08.2015
 * Time: 15:54
 */

namespace app\repositories;


use Yii;
use yii\base\Model;
use app\entities\DayEntity;
use yii\data\ArrayDataProvider;
use app\models\WeekStats;

class WeekStatsDaysRepository extends DayEntity
{
    /**
     * @var WeekStats
     */
    public $week;

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
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->week->getDays(),
            'sort' => [
                'attributes' => [
                    'date',
                    'day',
                    'weight',
                    'calories',
                ],
                'defaultOrder' => ['date' => SORT_ASC],
            ],
            'pagination' => false,
        ]);

        return $dataProvider;
    }
}