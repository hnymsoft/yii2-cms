<?php
$this->params['breadcrumbs'][] = ['label' => '系统管理','url'=>\yii\helpers\Url::toRoute(['setting/index'])];
$this->params['breadcrumbs'][] = ['label' => '模型列表','url'=>\yii\helpers\Url::toRoute(['module/index'])];
$this->params['breadcrumbs'][] = '添加';
?>
<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">模型编辑</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>