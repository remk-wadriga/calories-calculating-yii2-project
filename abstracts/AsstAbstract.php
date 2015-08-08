<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 08.08.2015
 * Time: 13:20
 */

namespace app\abstracts;

use yii\web\AssetBundle;

abstract class AsstAbstract extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
}