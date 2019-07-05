<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
$this->params['breadcrumbs'][] = ['label' => '内容列表','url'=>\yii\helpers\Url::toRoute(['content/index'])];
$this->params['breadcrumbs'][] = '详情';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">内容详情</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'layui-table','style'=>'margin-top:0'],
                'template' => '<tr><th width="90px;">{label}</th><td>{value}</td></tr>',
                'attributes' => [
                    'id',
                    'p_id',
                    'm_id',
                    'color',
                    'title',
                    'keywords',
                    'description',
                    'thumb',
                    'money',
                    'flag',
                    'author',
                    'click',
                    'source',
                    'status',
                    'create_addtime',
                    'update_addtime',
                    'create_user',
                    'update_user',
                ],
            ]) ?>
        </div>
    </div>
</div>
