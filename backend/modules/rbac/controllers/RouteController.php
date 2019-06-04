<?php

namespace rbac\controllers;

use Yii;
use rbac\models\Route;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * 路由
 * @package rbac\controllers
 */
class RouteController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    //'assign' => ['post'],
                    'remove' => ['post'],
                    'refresh' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 路由列表
     * @return string
     */
    public function actionIndex()
    {
        $model = new Route();
        return $this->render('index', ['routes' => $model->getRoutes()]);
    }

    /**
     * 添加路由
     * @return array
     */
    public function actionCreate()
    {
        Yii::$app->getResponse()->format = 'json';
        $routes = Yii::$app->getRequest()->post('route', '');
        $routes = preg_split('/\s*,\s*/', trim($routes), -1, PREG_SPLIT_NO_EMPTY);
        $model = new Route();
        $model->addNew($routes);
        return $model->getRoutes();
    }

    /**
     * 分配路由
     * @return array
     */
    public function actionAssign()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = new Route();
        $model->addNew($routes);
        Yii::$app->getResponse()->format = 'json';
        return $model->getRoutes();
    }

    /**
     * 移除路由
     * @return array
     */
    public function actionRemove()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = new Route();
        $model->remove($routes);
        Yii::$app->getResponse()->format = 'json';
        return $model->getRoutes();
    }

    /**
     * 更新路由
     * @return array
     */
    public function actionRefresh()
    {
        $model = new Route();
        $model->invalidate();
        Yii::$app->getResponse()->format = 'json';
        return $model->getRoutes();
    }
}
