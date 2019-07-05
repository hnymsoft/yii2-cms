<?php

use backend\assets\AnimateAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use backend\assets\LayuiAsset;
LayuiAsset::addCss($this, "@web/static/css/rbac.css");
LayuiAsset::register($this);
AnimateAsset::register($this);
$opts = Json::htmlEncode([
    'routes' => $routes,
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('js/_script.js'));
$animateIcon = ' <i class="layui-icon"></i>';
$this->params['breadcrumbs'][] = ['label' => '权限管理','url'=>\yii\helpers\Url::toRoute(['user/index'])];
$this->params['breadcrumbs'][] = '路由列表';
?>

<div class="layui-row">
    <div class="layui-col-md12 layui-form">
        <div class="layui-form-item">
            <div class="layui-input-inline" style="width: 100%;">
                <input id="inp-route" type="text" class="layui-input" placeholder="<?=Yii::t('rbac-admin', 'New route(s)');?>">
                <?=Html::a(Yii::t('rbac-admin', '添加') . $animateIcon, ['create'], ['class' => 'layui-btn  pos-abs-right','id' => 'btn-new',]);?>
            </div>
        </div>
    </div>
</div>

<div class="layui-row layui-col-space10">
    <div class="layui-col-md5">
        <div class="layui-form layui-form-item">
            <div class="layui-input-inline" style="width: 100%">
                <input class="layui-input search" data-target="available" placeholder="<?=Yii::t('rbac-admin', 'Search for available');?>">
                <?=Html::a('<span class="layui-icon layui-icon-refresh-3 layui-anim"></span>', ['refresh'], ['class' => 'layui-btn pos-abs-right','id' => 'btn-refresh',]);?>
            </div>
        </div>
        <select multiple size="25" class="layui-form-control list select-role-list" data-target="available"></select>
    </div>

    <div class="layui-col-md2" align="center">
        <div class="layui-row layui-col-space20" style="padding-top: 55px;">
            <div class="layui-col-xs12">
                <?=Html::a('&gt;&gt;' . $animateIcon, ['assign'], ['class' => 'layui-btn layui-btn-normal btn-assign','data-target' => 'available','title' => Yii::t('rbac-admin', 'Assign'),]);?>
            </div>
            <div class="layui-col-xs12">
                <?=Html::a('&lt;&lt;' . $animateIcon, ['remove'], ['class' => 'layui-btn layui-btn-danger btn-assign','data-target' => 'assigned','title' => Yii::t('rbac-admin', 'Remove'),]);?>
            </div>
        </div>
    </div>

    <div class="layui-col-md5">
        <div class="layui-form layui-form-item">
            <div class="layui-input-inline" style="width: 100%">
                <input class="layui-input search" data-target="assigned" placeholder="<?=Yii::t('rbac-admin', 'Search for assigned');?>">
            </div>
        </div>
        <select multiple size="25" class="layui-form-control list select-role-list" data-target="assigned"></select>
    </div>
</div>
