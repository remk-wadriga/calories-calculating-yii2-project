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
 */
class EnergyCoefficient extends ModelAbstract
{
    const WEIGHT_COEFFICIENT = 'WEIGHT';
    const AGE_COEFFICIENT = 'AGE';
    const SEX_COEFFICIENT = 'SEX';

    private static $_coefficientsNames = [
        self::WEIGHT_COEFFICIENT => 'Weight coefficient',
        self::AGE_COEFFICIENT => 'Age coefficient',
        self::SEX_COEFFICIENT => 'Sex coefficient',
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

    // END Public methods


    // Protected methods

    // END Protected methods
}
