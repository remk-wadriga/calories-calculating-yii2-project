<?php

namespace app\models;

use app\repositories\DiaryRepository;
use Yii;
use app\abstracts\ModelAbstract;
use app\interfaces\StatsModelInterface;
use yii\helpers\Json;

/**
 * This is the model class for table "week_stats".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $start_date
 * @property string $end_date
 * @property double $weight
 * @property double $calories
 * @property double $average_weight
 * @property double $average_calories
 * @property double $body_weight
 * @property integer $weighing_day
 * @property string $days_stats
 *
 * @property integer $userId
 * @property float $averageWeight
 * @property float $averageCalories
 * @property float $bodyWeight
 * @property string $daysStats
 * @property string $startDate
 * @property string $endDate
 * @property integer $weighingDay
 *
 * @property User $user
 */
class WeekStats extends ModelAbstract implements StatsModelInterface
{
    protected $_days;

    public static function tableName()
    {
        return 'week_stats';
    }

    public function rules()
    {
        return [
            [['weight', 'calories', 'average_weight', 'average_calories'], 'required'],
            [['user_id', 'userId', 'weighing_day', 'weighingDay'], 'integer'],
            [['start_date', 'end_date', 'days_stats', 'daysStats'], 'safe'],
            [['weight', 'calories', 'average_weight', 'average_calories', 'body_weight', 'averageWeight', 'averageCalories', 'bodyWeight'], 'number'],
            [['days_stats', 'start_date', 'end_date', 'daysStats', 'startDate', 'endDate'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'userId' => $this->t('User ID'),
            'startDate' => $this->t('Start date'),
            'endDate' => $this->t('End date'),
            'weight' => $this->t('Weight'),
            'calories' => $this->t('Calories'),
            'averageWeight' => $this->t('Average weight'),
            'averageCalories' => $this->t('Average calories'),
            'bodyWeight' => $this->t('Body weight'),
            'daysStats' => $this->t('Days stats'),
            'weighingDay' => $this->t('Weighing day'),
        ];
    }


    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    // END Depending

    // Event handlers

    public function beforeSave($insert)
    {
        if ($this->user_id === null) {
            $this->user_id = Yii::$app->user->id;
        }

        return parent::beforeSave($insert);
    }

    // END Event handlers



    // Getters and setters
    /*
     * @property integer $
     * @property float $
     * @property float $
     * @property float $
     * @property string $
     * @property string $
     * @property string $
     */

    /**
     * @param $value
     * @return $this
     */
    public function setUserId($value)
    {
        $this->user_id = $value;
        return $this;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setAverageWeight($value)
    {
        $this->average_weight = $value;
        return $this;
    }

    public function getAverageWeight()
    {
        return $this->average_weight;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setAverageCalories($value)
    {
        $this->average_calories = $value;
        return $this;
    }

    public function getAverageCalories()
    {
        return $this->average_calories;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setBodyWeight($value)
    {
        $this->body_weight = $value;
        return $this;
    }

    public function getBodyWeight()
    {
        return $this->body_weight;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDaysStats($value)
    {
        $this->days_stats = $value;
        return $this;
    }

    public function getDaysStats()
    {
        return $this->days_stats;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setStartDate($value)
    {
        $this->start_date = $value;
        return $this;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEndDate($value)
    {
        $this->end_date = $value;
        return $this;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param integer $value
     * @return $this
     */
    public function setWeighingDay($value)
    {
        $this->weighing_day = $value;
        return $this;
    }

    public function getWeighingDay()
    {
        return $this->weighing_day;
    }

    // END Getters and setters


    // Public methods

    /**
     * @return \stdClass[]
     */
    public function getDays()
    {
        if ($this->_days !== null) {
            return $this->_days;
        }

        $this->_days = [];

        if (!empty($this->days_stats)) {
            $days = Json::decode($this->days_stats);
            if (!empty($days)) {
                $timeService = Yii::$app->timeService;
                foreach ($days as $day) {
                    $day['deyName'] = $this->t($timeService->getDeyName($day['date']));
                    $this->_days[] = (object)$day;
                }
            }
        }

        return $this->_days;
    }

    // END Public methods


    // Protected methods

    protected function findUserId()
    {
        $userId = $this->getUserId();
        if (!empty($userId)) {
            return $userId;
        }

        if (Yii::$app->request->isConsoleRequest) {
            return null;
        }

        $user = Yii::$app->get('user');
        if (!empty($user)) {
            return $user->getId();
        }

        return null;
    }

    // END Protected methods


    // Implementation StatsModelInterface

    /**
     * @param string $date
     * @param integer|null $limit
     * @return array
     */
    public function findDaysByEndDate($date, $limit = null)
    {
        $query = DiaryRepository::getQuery([], false);

        $query
            ->andWhere(['<=', 'date', $date])
            ->orderBy('date')
            ->asArray();

        $userId = $this->findUserId();
        if (!empty($userId)) {
            $query->andWhere(['user_id' => $userId]);
        }
        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->all();
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function findDaysByStartAndEndDate($startDate, $endDate)
    {
        $query = DiaryRepository::getQuery([], false);

        $query
            ->andWhere(['>=', 'date', $startDate])
            ->andWhere(['<=', 'date', $endDate])
            ->orderBy('date')
            ->asArray();

        $userId = $this->findUserId();
        if (!empty($userId)) {
            $query->andWhere(['user_id' => $userId]);
        }

        return $query->all();
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function findByStartAndAndDates($startDate, $endDate)
    {
        $query = self::find()
            ->where(['>=', 'start_date', $startDate])
            ->andWhere(['<=', 'end_date', $endDate])
            ->asArray();

        $userId = $this->findUserId();
        if (!empty($userId)) {
            $query->andWhere(['user_id' => $userId]);
        }

        return $query->one();
    }

    // END Implementation StatsModelInterface
}
