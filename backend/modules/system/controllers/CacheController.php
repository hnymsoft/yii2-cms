<?php

namespace system\controllers;

use Yii;
use common\models\Cache;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class CacheController
 * @package system\controllers
 */
class CacheController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'flush' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 更新系统缓存
     * @return string
     */
    public function actionFlush(){
        $type = post('type');
        if(Cache::run($type)){
            return ajaxReturnFailure('更新完成');
        }else{
            return ajaxReturnFailure('更新失败');
        }
    }
}
