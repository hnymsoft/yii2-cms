<?php
$this->params['breadcrumbs'][] = ['label' => '会员管理','url'=>\yii\helpers\Url::toRoute(['member/index'])];
$this->params['breadcrumbs'][] = ['label' => '会员级别列表','url'=>\yii\helpers\Url::toRoute(['memberrank/index'])];
$this->params['breadcrumbs'][] = '添加';
?>
<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">会员级别编辑</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>