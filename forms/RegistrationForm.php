<?php

namespace app\forms;

use Yii;
use app\abstracts\FormAbstract;
use app\models\User;

/**
 * RegistrationForm is the model behind the contact form.
 */
class RegistrationForm extends FormAbstract
{
    public $email;
    public $password;
    public $retypePassword;
    public $firstName;
    public $lastName;
    public $phone;
    public $about;
    public $weight;

    private $_user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password', 'retypePassword'], 'required'],
            ['retypePassword', 'compare', 'compareAttribute' => 'password'],
            [['password', 'retypePassword'], 'string', 'min' => 3, 'max' => 255],
            [['email'], 'email'],
            [['email', 'firstName', 'lastName'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 126],
            [['about'], 'string', 'max' => 64000],
            [['weight'], 'integer'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'email' => $this->t('Email'),
            'password' => $this->t('Password'),
            'firstName' => $this->t('First name'),
            'lastName' => $this->t('Last name'),
            'phone' => $this->t('Phone'),
            'about' => $this->t('About me'),
            'weight' => $this->t('Weight'),
        ];
    }

    public function registration()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_user = new User();
        $this->_user->setAttributes($this->getAttributes());

        if (!$this->_user->validate(['email'])) {
            $this->addError('email', $this->_user->getErrors(['email']));
            return false;
        }

        return $this->_user->save(false);
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user !== null) {
            return $this->_user;
        }

        return $this->_user = User::findByUsername($this->email);
    }
}
