<?php

namespace app\models;

use Yii;
use app\abstracts\ModelAbstract;

/**
 * This is the model class for table "energy_coefficients".
 *
 * @property integer $id
 * @property string $type
 * @property string $value
 * @property double $coefficient
 * @property string $typeName
 * @property string $valueName
 */
class EnergyCoefficient extends ModelAbstract
{
    const WEIGHT_COEFFICIENT = 'WEIGHT';
    const AGE_COEFFICIENT = 'AGE';
    const SEX_COEFFICIENT = 'SEX';
    const SEX_MALE = 'm';
    const SEX_FEMALE = 'f';

    private static $_coefficientsNames = [
        self::WEIGHT_COEFFICIENT => 'Weight coefficient',
        self::AGE_COEFFICIENT => 'Age coefficient',
        self::SEX_COEFFICIENT => 'Sex coefficient',
    ];

    private static $_valueNames = [
        self::SEX_MALE => 'Male',
        self::SEX_FEMALE => 'Female',
    ];


    public static function tableName()
    {
        return 'energy_coefficient';
    }

    public function rules()
    {
        return [
            [['type'], 'string'],
            [['value'], 'required'],
            [['coefficient'], 'number'],
            [['value'], 'string', 'max' => 7],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
            'type' => $this->t('Type'),
            'value' => $this->t('Value'),
            'coefficient' => $this->t('Coefficient'),
            'typeName' => $this->t('Type'),
            'valueName' => $this->t('Value'),
        ];
    }

    // Depending

    // END Depending


    // Event handlers

    // END Event handlers


    // Getters and setters

    // Getters and setters


    // Public methods

    /**
     * @return array
     */
    public function getCoefficients()
    {
        $coefficients = [];
        foreach (self::$_coefficientsNames as $coefficient => $name) {
            $coefficients[$coefficient] = $this->t($name);
        }
        return $coefficients;
    }

    public function getTypeName()
    {
        $typeName = self::$_coefficientsNames[$this->type];
        return $this->t($typeName);
    }

    public function getValueName()
    {
        if ($this->type == self::SEX_COEFFICIENT){
            return $this->t(self::$_valueNames[$this->value]);
        } else {
            return $this->value;
        }
    }

    // END Public methods


    // Protected methods

    // END Protected methods
}
