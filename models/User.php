<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $password_hash
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $avatar
 * @property integer $status
 * @property string $role
 * @property string $last_login_date
 * @property string $registration_date
 * @property integer $weighing_day
 * @property integer $start_weight
 *
 * @property string $password
 * @property string $firstName
 * @property string $lastName
 * @property string $lastLoginDate
 * @property string $registrationDate
 * @property string $username
 * @property integer $weighingDay
 * @property string $newPassword
 * @property integer $startWeight
 *
 */
class User extends ModelAbstract implements IdentityInterface
{
    const ROLE_GUEST = 'GUEST';
    const ROLE_USER = 'USER';
    const ROLE_ADMIN = 'ADMIN';

    const STATUS_NEW = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_BLOCK = 3;

    protected $_currentWeight;

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['email', 'password_hash'], 'required'],
            [['status', 'weighing_day', 'weighingDay'], 'integer'],
            [['last_login_date', 'registration_date', 'lastLoginDate', 'registrationDate'], 'safe'],
            [['email', 'first_name', 'last_name', 'password', 'username', 'firstName', 'lastName', 'newPassword'], 'string', 'max' => 255],
            [['password_hash'], 'string', 'max' => 500],
            [['avatar'], 'string', 'max' => 500],
            [['phone'], 'string', 'max' => 126],
            [['role'], 'string', 'max' => 24],
            [['start_weight', 'startWeight'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => $this->t('Email'),
            'password_hash' => $this->t('Password Hash'),
            'newPassword' => $this->t('Password'),
            'first_name' => $this->t('First Name'),
            'last_name' => $this->t('Last Name'),
            'firstName' => $this->t('First Name'),
            'lastName' => $this->t('Last Name'),
            'phone' => $this->t('Phone'),
            'avatar' => $this->t('Avatar'),
            'status' => $this->t('Status'),
            'role' => $this->t('Role'),
            'last_login_date' => $this->t('Last Login Date'),
            'registration_date' => $this->t('Registration Date'),
            'lastLoginDate' => $this->t('Last Login Date'),
            'registrationDate' => $this->t('Registration Date'),
            'weighing_day' => $this->t('Weighing Day'),
            'weighingDay' => $this->t('Weighing Day'),
            'startWeight' => $this->t('Start weight') . ' (' . $this->getFormattedRegistrationDate() . ')',
            'plannedCalories' => $this->t('Planned calories'),
        ];
    }


    // Depending


    // END Depending


    // Event handlers

    public function beforeSave($insert)
    {
        if ($insert) {
            if ($this->getRegistrationDate() === null) {
                $this->setRegistrationDate(Yii::$app->timeService->getCurrentDateTime());
            }

            if ($this->status === null) {
                $this->status = self::STATUS_NEW;
            }

            if ($this->role === null) {
                $this->role = self::ROLE_USER;
            }
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }

    // END Event handlers


    // Getters and setters

    /**
     * @param $value
     * @return $this
     */
    public function setPassword($value)
    {
        if ($this->getRegistrationDate() === null) {
            $this->setRegistrationDate(Yii::$app->timeService->getCurrentDateTime());
        }
        $this->password_hash = $this->createPasswordHash($value);
        return $this;
    }

    public function getPassword()
    {
        return $this->password_hash;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setFirstName($value)
    {
        $this->first_name = $value;
        return $this;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLastName($value)
    {
        $this->last_name = $value;
        return $this;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLastLoginDate($value)
    {
        $this->last_login_date = $value;
        return $this;
    }

    public function getLastLoginDate()
    {
        return $this->last_login_date;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setRegistrationDate($value)
    {
        $this->registration_date = $value;
        return $this;
    }

    public function getRegistrationDate()
    {
        return $this->registration_date;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setUsername($value)
    {
        $this->email = $value;
        return $this;
    }

    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setWeighingDay($value)
    {
        $this->weighing_day = (string)$value;
        return $this;
    }

    public function getWeighingDay()
    {
        return (int)$this->weighing_day;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setNewPassword($value)
    {
       $this->password_hash =  $this->createPasswordHash($value);
    }

    public function getNewPassword()
    {
        return null;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setStartWeight($value)
    {
        $this->start_weight = $value;
        return $this;
    }

    public function getStartWeight()
    {
        return $this->start_weight;
    }

    // END Getters and setters


    // Public methods

    public function validatePassword($password)
    {
        return $this->createPasswordHash($password) === $this->getPassword();
    }

    /**
     * @param string $userName
     * @return null|self
     */
    public static function findByUsername($userName)
    {
        return self::findOne(['email' => $userName]);
    }

    /**
     * @return string
     */
    public function getFormattedRegistrationDate()
    {
        return Yii::$app->timeService->formatDate($this->getRegistrationDate());
    }

    /**
     * @return int
     */
    public function getCurrentWeight()
    {
        if ($this->_currentWeight !== null) {
            return $this->_currentWeight;
        }

        $this->_currentWeight = $this->getStartWeight();

        return $this->_currentWeight;
    }

    // END Public methods


    // Protected methods

    protected function createPasswordHash($password)
    {
        return hash(Yii::$app->params['crypt_alo'], $password . $this->getRegistrationDate() . Yii::$app->params['salt']);
    }

    // END Protected methods


    // Implements IdentityInterface
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {

    }

    public function validateAuthKey($authKey)
    {

    }
    // END Implements IdentityInterface
}
