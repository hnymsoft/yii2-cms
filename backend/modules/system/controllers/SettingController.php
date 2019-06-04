<?php

namespace system\controllers;


use backend\controllers\BaseController;
use common\models\Setting;

class SettingController extends BaseController
{
    /**
     * 系统设置
     * @return string
     */
    public function actionIndex(){
        $post_data = \Yii::$app->request->post();
        if(\Yii::$app->request->isPost && !empty($post_data)){
            foreach ($post_data as $k => $v){
                if($k == '_csrf-backend'){
                    continue;
                }
                $one = Setting::findOne(['item' => $k]);
                $one->value = $v;
                if(!$one->save(false)){
                    return ajaxReturnFailure("更新失败：{$one->name}");
                }
            }
            return ajaxReturnSuccess("更新成功");
        }
        return $this->render('index',[
            'model' => Setting::find()->orderBy('order asc')->all()
        ]);
    }
}