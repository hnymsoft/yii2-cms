<?php

namespace rbac\controllers;

use Yii;

/**
 * Class DefaultController
 * @package rbac\controllers
 */
class DefaultController extends \yii\web\Controller
{

    /**
     * Action index
     */
    public function actionIndex($page = 'README.md')
    {
        if (strpos($page, '.png') !== false) {
            $file = Yii::getAlias("@rbac/{$page}");
            return Yii::$app->getResponse()->sendFile($file);
        }
        return $this->render('index', ['page' => $page]);
    }
}
