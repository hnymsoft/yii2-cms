<?php
namespace backend\controllers;
use common\models\Collect;
use GuzzleHttp\Client;
use QL\Ext\AbsoluteUrl;
use QL\QueryList;
use rbac\models\User;
use Yii;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends BaseController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'checkpassword' => ['POST'],
                ],
            ],
        ];
    }


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

    /**
     * 默认首页
     * @return string
     */
    public function actionIndex(){
        return $this->render('index');
    }

    /**
     * 锁屏检测登陆密码
     * @return string
     */
    public function actionCheckpassword(){
        $password = post('password');
        if(!$password){
            return ajaxReturnFailure('密码不能为空!');
        }
        $user = User::findIdentity(Yii::$app->user->identity->id);
        if (!$user || !$user->validatePassword($password)) {
            return ajaxReturnFailure('密码错误！');
        }
        return ajaxReturnSuccess('验证成功!');
    }

    /**
     * 测试用
     */
    public function actionTest(){
        $query = new Collect();
        $conf = $query->getConf();
        $list = $query->getCollectionData($conf['list']['url'],$conf['list'],$conf['options']);
        if(!$list){
            return ajaxReturnFailure('暂无采集数据！');
        }
        foreach ($list as $key => $val){
            $data[$key] = $query->getCollectionData($val['url'],$conf['content'],$conf['options']);
        }
        dd($data);
    }



}
