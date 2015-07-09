<?php

namespace app\interfaces;


interface ExtensionInterface
{
    /**
     * @param array $config
     * @return \app\abstracts\ExtensionAbstract
     */
    public static function getIdentity($config = []);
}