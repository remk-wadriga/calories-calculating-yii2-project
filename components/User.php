<?php

namespace app\components;

use yii\web\User as YiiUser;
use app\models\User as Identity;

/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 13.05.2015
 * Time: 11:18
 *
 * @property Identity $identity
 *
 * @property string $name
 * @property integer $weighingDay
 */
class User extends YiiUser
{
    public function getName()
    {
        if ($this->getIsGuest()) {
            return null;
        }

        $identity = $this->getIdentity();

        if ($identity === null) {
            return null;
        }

        $name = $identity->firstName;
        $name .= $identity->lastName ? ' ' . $identity->lastName : '';

        return $name ? $name : $identity->email;
    }

    /**
     * @param bool $autoRenew
     * @return null|\app\models\User
     */
    public function getIdentity($autoRenew = true)
    {
        return parent::getIdentity($autoRenew);
    }

    public function getWeighingDay()
    {
        return $this->getIdentity()->weighingDay;
    }
}