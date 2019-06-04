<?php

use backend\assets\AnimateAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;
use yii\widgets\DetailView;
use backend\assets\LayuiAsset;

LayuiAsset::register($this);
AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'items' => $model->getItems(),
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('js/_script.js'));
$animateIcon = ' <i class="layui-icon"></i>';
?>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <a href="" class="layui-btn layui-btn-primary layui-btn-sm" id="prev">返回上一页</a>
        </div>
        <div class="layui-card-body">
            <?=DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'layui-table'],
                'attributes' => [
                    'name',
                    'description:ntext',
                    'ruleName',
                    'data:ntext',
                ],
                'template' => '<tr><th style="width:8%">{label}</th><td>{value}</td></tr>',
            ]);?>
        </div>
    </div>

    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-row">
                <div class="layui-col-md5">
                    <div class="layui-form layui-form-item">
                        <div class="layui-input-inline" style="width: 100%">
                            <input class="layui-input search" data-target="available" placeholder="<?=Yii::t('rbac-admin', 'Search for available');?>">
                        </div>
                    </div>
                    <select multiple size="30" class="layui-form-control list select-role-list" data-target="available"></select>
                </div>

                <div class="layui-col-md2" align="center">
                    <div class="layui-row layui-col-space20" style="padding-top: 55px;">
                        <div class="layui-col-xs12">
                            <?=Html::a('&gt;&gt;' . $animateIcon, ['assign', 'id' => $model->name], [
                                'class' => 'layui-btn layui-btn-normal btn-assign',
                                'data-target' => 'available',
                                'title' => Yii::t('rbac-admin', 'Assign'),
                            ]);?>
                        </div>
                        <div class="layui-col-xs12">
                            <?=Html::a('&lt;&lt;' . $animateIcon, ['remove', 'id' => $model->name], [
                                'class' => 'layui-btn layui-btn-danger btn-assign',
                                'data-target' => 'assigned',
                                'title' => Yii::t('rbac-admin', 'Remove'),
                            ]);?>
                        </div>
                    </div>
                </div>

                <div class="layui-col-md5">
                    <div class="layui-form layui-form-item">
                        <div class="layui-input-inline" style="width: 100%">
                            <input class="layui-input search" data-target="assigned" placeholder="<?=Yii::t('rbac-admin', 'Search for assigned');?>">
                        </div>
                    </div>
                    <select multiple size="30" class="layui-form-control list select-role-list" data-target="assigned"></select>
                </div>
            </div>
        </div>
    </div>

</div>