<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AdPosition */

$this->title = $model->position_id;
$this->params['breadcrumbs'][] = ['label' => 'Ad Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <a href="<?=Yii::$app->request->referrer?>" class="layui-btn layui-btn-primary layui-btn-sm">返回上一页</a>
        </div>
        <div class="layui-card-body">
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
