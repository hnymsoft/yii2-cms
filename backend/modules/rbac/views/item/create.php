<?php
$this->params['breadcrumbs'][] = ['label' => '角色（权限）列表','url'=>\yii\helpers\Url::toRoute(['role/index'])];
$this->params['breadcrumbs'][] = '添加';
?>
<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">角色（权限）添加</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= $this->render('_form', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>