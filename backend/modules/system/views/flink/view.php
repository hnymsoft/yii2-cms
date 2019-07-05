<?php
$this->params['breadcrumbs'][] = ['label' => '扩展管理','url'=>\yii\helpers\Url::toRoute(['flink/index'])];
$this->params['breadcrumbs'][] = ['label' => '友链列表','url'=>\yii\helpers\Url::toRoute(['flink/index'])];
$this->params['breadcrumbs'][] = '编辑';

\yii\web\YiiAsset::register($this);
?>
<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">友链编辑</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'layui-table','style'=>'margin-top:0'],
                'attributes' => [
                    'id',
                    'webname',
                    'linkurl',
                    'logo',
                    'typeid',
                    'introduce',
                    'order',
                    'status',
                    'addtime:datetime',
                ],
            ]) ?>
        </div>
    </div>
</div>