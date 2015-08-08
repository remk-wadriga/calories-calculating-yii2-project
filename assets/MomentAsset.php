<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 08.08.2015
 * Time: 14:14
 */

namespace app\assets;

use app\abstracts\AsstAbstract;

class MomentAsset extends AsstAbstract
{
    public $baseUrl = '@web/ext/moment';

    public $js = [
        'js/moment.min.js'
    ];
}