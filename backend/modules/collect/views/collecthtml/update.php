<?php
$this->params['breadcrumbs'][] = ['label' => '临时内容列表','url'=>\yii\helpers\Url::toRoute(['collecthtml/index'])];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">临时内容编辑</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>