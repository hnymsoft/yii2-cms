<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Collect */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Collects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="collect-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'm_id',
            'name',
            'encoding',
            'num',
            'baseconfig:ntext',
            'listconfig:ntext',
            'arcconfig:ntext',
            'status',
            'create_datetime:datetime',
            'update_datetime:datetime',
            'create_user',
            'update_user',
        ],
    ]) ?>

</div>
