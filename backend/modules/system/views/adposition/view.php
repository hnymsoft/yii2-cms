<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
$this->params['breadcrumbs'][] = ['label' => '扩展管理','url'=>\yii\helpers\Url::toRoute(['flink/index'])];
$this->params['breadcrumbs'][] = ['label' => '广告位列表','url'=>\yii\helpers\Url::toRoute(['adposition/index'])];
$this->params['breadcrumbs'][] = '详情';
\yii\web\YiiAsset::register($this);
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">广告位详情</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'layui-table'],
                'template' => '<tr><th width="90px;">{label}</th><td>{value}</td></tr>',
                'attributes' => [
                    'position_id',
                    'position_name',
                    'ad_width',
                    'ad_height',
                    'position_desc',
                    'position_style:ntext',
                ],
            ]) ?>
        </div>
    </div>
</div>
