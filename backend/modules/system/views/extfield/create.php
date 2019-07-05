<?php
$this->params['breadcrumbs'][] = ['label' => '系统管理','url'=>\yii\helpers\Url::toRoute(['setting/index'])];
$this->params['breadcrumbs'][] = ['label' => '模型字段列表','url'=>\yii\helpers\Url::toRoute(['extfield/index'])];
$this->params['breadcrumbs'][] = '添加';
?>
<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">字段添加</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>