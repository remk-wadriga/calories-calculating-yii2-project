<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 08.08.2015
 * Time: 13:08
 */

namespace app\assets;

use app\abstracts\AsstAbstract;

class BootstrapDatepickerAsset extends AsstAbstract
{
    public $baseUrl = '@web/ext/bootstrap-datepicker/1.4.0';

    public $css = [
        'css/bootstrap-datepicker3.min.css',
    ];

    public $js = [
        'js/bootstrap-datepicker.min.js',
        'locales/bootstrap-datepicker.ru.min.js',
        'locales/bootstrap-datepicker.en.min.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}