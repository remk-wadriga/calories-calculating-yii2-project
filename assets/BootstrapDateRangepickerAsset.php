<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 08.08.2015
 * Time: 14:15
 */

namespace app\assets;

use app\abstracts\AsstAbstract;

class BootstrapDateRangepickerAsset extends AsstAbstract
{
    public $baseUrl = '@web/ext/bootstrap-daterangepicker';

    public $css = [
        'css/daterangepicker.css',
    ];

    public $js = [
        'js/daterangepicker.js',
    ];

    public $depends = [
        'app\assets\AppAsset',
        'app\assets\MomentAsset',
    ];
}