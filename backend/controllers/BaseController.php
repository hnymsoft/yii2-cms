<?php
/**
 * Created by PhpStorm.
 * User: guoshuaitao
 * Date: 2019/5/27
 * Time: 10:25
 */

namespace backend\controllers;


use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * 不需要验证csrf的action
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action) {
        \Yii::$app->params['_path'] = \Yii::$app->controller->module->id.'/'.\Yii::$app->controller->id.'/'.\Yii::$app->controller->action->id;

        $currentaction = $action->id;
        $novalidactions = [
            'checkpassword',
            'start'
        ];
        if(in_array($currentaction,$novalidactions)) {
            $action->controller->enableCsrfValidation = false;
        }
        parent::beforeAction($action);
        return true;
    }
}