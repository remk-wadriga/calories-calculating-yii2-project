<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "plan".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $start_date
 * @property string $end_date
 * @property string $direction
 *
 * @property integer $userId
 * @property string $startDate
 * @property string $endDate
 * @property string $period
 *
 * @property Menu[] $menus
 * @property User $user
 */
class Plan extends ModelAbstract
{
    const PLAN_DRYING = 'drying';
    const PLAN_WEIGHT = 'weight';
    const PLAN_PRESERVATION = 'preservation';

    public static function tableName()
    {
        return 'plan';
    }

    public function rules()
    {
        return [
            [['user_id', 'start_date', 'end_date'], 'required'],
            [['user_id'], 'integer'],
            [['start_date', 'end_date', 'period'], 'safe'],
            [['direction'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'start_date' => $this->t('Start date'),
            'end_date' => $this->t('End date'),
            'direction' => $this->t('Direction'),
            'period' => $this->t('Time period'),
        ];
    }


    // Depending

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['plan_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    // AND Depending


    // Event handlers

    // END Event handlers



    // Getters and setters

    /**
     * @param $val
     * @return $this
     */
    public function setUserId($val)
    {
        $this->user_id = $val;
        return $this;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param $val
     * @return $this
     */
    public function setStartDate($val)
    {
        $this->start_date = $val;
        return $this;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param $val
     * @return $this
     */
    public function setEndDate($val)
    {
        $this->end_date = $val;
        return $this;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param $val
     * @return $this
     */
    public function setPeriod($val)
    {
        $period = explode(' - ', trim($val));
        if(count($period) === 2){
            $this->setStartDate($period[0]);
            $this->setEndDate($period[1]);
        }
        return $this;
    }

    public function getPeriod()
    {
        return $this->getStartDate() !== null ? $this->getStartDate() . ' - ' . $this->getEndDate() : null;
    }

    // END Getters and setters



    // Public functions

    public static function getDirectionsListItems()
    {
        return [
            self::PLAN_DRYING => parent::t('Drying'),
            self::PLAN_WEIGHT => parent::t('Weighting'),
            self::PLAN_PRESERVATION => parent::t('Preservation'),
        ];
    }

    // END Public functions
}
