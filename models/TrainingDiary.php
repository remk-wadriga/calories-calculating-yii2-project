<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "training_diary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date
 *
 * @property integer $userId
 *
 * @property User $user
 * @property Training[] $trainings
 */
class TrainingDiary extends ModelAbstract
{
    public static function tableName()
    {
        return 'training_diary';
    }

    public static function TrainingDiaryTrainingsTableName()
    {
        return 'training_diary_trainings';
    }

    public function rules()
    {
        return [
            [['user_id', 'date'], 'required'],
            [['user_id', 'userId'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'user_id' => $this->t('User ID'),
            'userId' => $this->t('User ID'),
            'date' => $this->t('Date'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainings()
    {
        return $this->hasMany(Training::className(), ['id' => 'training_id'])->viaTable(self::TrainingDiaryTrainingsTableName(), ['diary_id' => 'id']);
    }

    // END Depending


    // Event handlers

    // END Event handlers


    // Getters and setters

    // Getters and setters


    // Public methods

    // END Public methods


    // Protected methods

    // END Protected methods
}
