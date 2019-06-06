<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdPosition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-box-dialog">

    <?php $form = ActiveForm::begin([
        'id' => 'item-form',
        'options' => ['class' => 'layui-form'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item'],
            'labelOptions' => ['class' => 'layui-form-label','align'=>'right'],
            'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div><span class="help-block">{error}</span>',
        ],
    ]); ?>
    <?= $form->field($model, 'position_name')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'ad_width')->textInput(['class'=>'layui-input']) ?>
    <?= $form->field($model, 'ad_height')->textInput(['class'=>'layui-input']) ?>
    <?= $form->field($model, 'position_desc')->textarea(['row' => 6,'class'=>'layui-textarea']) ?>
    <div class='layui-form-item'>
        <div class="layui-form-label"></div>
        <div class="layui-input-block">
            <?=
            Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', '添加') : Yii::t('rbac-admin', '编辑'), ['class' => $model->isNewRecord? 'layui-btn' : 'layui-btn layui-btn-normal'])
            ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
