<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 21.07.2015
 * Time: 19:06
 */

namespace app\abstracts;

use Yii;
use yii\base\Model;
use app\components\Query;

abstract class EntityAbstract extends Model
{
    public $id;
    public $modelClass;

    public function init()
    {
        parent::init();
    }

    public function t($message, $params = [])
    {
        return Yii::$app->view->t($message, $params);
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['modelClass'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('ID'),
        ];
    }

    /**
     * @return \app\components\Query
     */
    public static function find()
    {
        $query = new Query();
        $query->modelClass = static::className();
        return $query;
    }
}