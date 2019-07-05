<?php
$this->params['breadcrumbs'][] = ['label' => '栏目列表','url'=>\yii\helpers\Url::toRoute(['channel/index'])];
$this->params['breadcrumbs'][] = '添加';
?>
<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">栏目编辑</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= $this->render('_form', [
                'model' => $model,
                'channelDropdown' => $channelDropdown
            ]) ?>
        </div>
    </div>
</div>