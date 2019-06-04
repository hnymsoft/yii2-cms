<?php

namespace rbac\controllers;

use Yii;
use rbac\models\Log;
use rbac\models\searchs\Log as LogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 操作日志
 * Class LogController
 * @package rbac\controllers
 */
class LogController extends Controller
{
    /**
     * 日志列表
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LogSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * 日志详情
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 日志详情（单条数据）
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Log::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('信息不存在');
        }
    }
}
