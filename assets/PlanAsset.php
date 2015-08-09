<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 08.08.2015
 * Time: 13:56
 */

namespace app\assets;

use app\abstracts\AsstAbstract;

class PlanAsset extends AsstAbstract
{
    public $baseUrl = '@web/pages/plan';

    public $js = [
        'js/plan.js'
    ];

    public $depends = [
        'app\assets\AppAsset',
    ];
}