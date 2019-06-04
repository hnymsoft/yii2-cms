<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AppAsset;
use common\models\ArticleGroup;
/* @var $this yii\web\View */
/* @var $model common\models\searchs\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */
AppAsset::register($this);
?>
<div class="search-box">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'layui-form layui-form-item'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-inline'],
            'labelOptions' => ['class' => 'layui-form-label'],
            'template' => '<div class="layui-inline">{label}<div class="layui-input-inline">{input}</div></div><span class="help-block" style="display: inline-block;">{error}</span>',
	   ],
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['class'=>'layui-input search_input']) ?>
    <div class="layui-inline">
        <?= Html::submitButton('查找', ['class' => 'layui-btn layui-btn-normal']) ?>
        <?= Html::a('添加',\yii\helpers\Url::to(['create']), ['class' => "layui-btn layui-default-add"])?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
