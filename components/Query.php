<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 21.07.2015
 * Time: 19:33
 */

namespace app\components;

use Yii;
use yii\db\BaseActiveRecord;
use yii\db\Query AS YiiQuery;


class Query extends YiiQuery
{
    public $modelClass;
    public $asArray;

    public function init()
    {
        parent::init();
        $this->modelClass = get_called_class();
        $this->asArray = false;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function asArray($value)
    {
        $this->asArray = (bool)$value;
        return $this;
    }

    /**
     * @param array $rows
     * @return array
     */
    public function populate($rows)
    {
        if($this->indexBy === null){
            if($this->asArray){
                return $rows;
            }
            $result = [];
            foreach($rows as $row){
                $result[] = $this->createObject($row);
            }
            return $result;
        }else{
            return parent::populate($rows);
        }
    }

    /**
     * @param $row
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    protected function createObject($row)
    {
        $row['class'] = $this->modelClass;
        return Yii::createObject($row);
    }
}