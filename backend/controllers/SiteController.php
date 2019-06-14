<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'main-index2'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor'=>0x000000,//背景颜色
                'width' => 100,
                'height' => 40,
                'padding' => 0,
                'minLength' => 4,
                'maxLength' => 4,
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>8,        //设置字符偏移量 有效果
                'testLimit'=>999,
            ]
        ];
    }

    public function actionIndex(){
        return $this->render('index');
    }

}
