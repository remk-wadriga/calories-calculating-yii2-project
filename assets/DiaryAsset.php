<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 08.08.2015
 * Time: 13:22
 */

namespace app\assets;

use app\abstracts\AsstAbstract;

class DiaryAsset extends AsstAbstract
{
    public $js = [
        'js/diary.js'
    ];

    public $depends = [
        'app\assets\BootstrapDatepickerAsset',
        'app\assets\AppAsset',
    ];
}