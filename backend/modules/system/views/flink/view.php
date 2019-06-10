<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Flink */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Flinks', 'url' => ['index']];
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
