<?php
$this->params['breadcrumbs'][] = ['label' => '权限管理','url'=>\yii\helpers\Url::toRoute(['user/index'])];
$this->params['breadcrumbs'][] = ['label' => '规则列表','url'=>\yii\helpers\Url::toRoute(['rule/index'])];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">规则编辑</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>