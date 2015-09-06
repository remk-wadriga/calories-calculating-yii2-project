<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 06.09.2015
 * Time: 11:48
 */

namespace app\events;

use yii\base\Event;

class DiaryEvent extends Event
{
    /**
     * @var string
     */
    public $date;
}