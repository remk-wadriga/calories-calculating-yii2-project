<?php

namespace app\abstracts;

use Yii;
use yii\web\Controller;

class ControllerAbstract extends Controller
{
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function render($view = null, $params = [])
    {
        if (is_array($view)) {
            $params = $view;
            $view = null;
        }

        if ($view === null) {
            $view = $this->action->id;
        }

        return parent::render($view, $params);
    }

    public function setFlash($key, $message)
    {
        Yii::$app->session->setFlash($key, $message);
    }

    protected function isPost()
    {
        return Yii::$app->request->getIsPost();
    }

    protected function post($param = null, $defaultValue = null)
    {
        return Yii::$app->request->post($param, $defaultValue);
    }

    protected function isAjax()
    {
        return Yii::$app->request->getIsAjax();
    }
}