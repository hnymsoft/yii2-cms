<?php
$this->params['breadcrumbs'][] = ['label' => '菜单列表','url'=>\yii\helpers\Url::toRoute(['menu/index'])];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">菜单编辑</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= $this->render('_form', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>