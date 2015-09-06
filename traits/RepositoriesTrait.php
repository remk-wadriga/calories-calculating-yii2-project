<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 06.09.2015
 * Time: 13:37
 */

namespace app\traits;

/**
 * Class RepositoriesTrait
 * @package app\traits
 *
 * @method modelName
 */
trait RepositoriesTrait
{
    /**
     * @param string $paramName
     * @param array $params
     */
    public function addParam($paramName, &$params)
    {
        if (isset($params[$paramName])) {
            $modelName = $this->modelName();
            if (!isset($params[$modelName])) {
                $params[$modelName] = [];
            }
            $params[$modelName][$paramName] = $params[$paramName];
            unset($params[$paramName]);
        }
    }
}