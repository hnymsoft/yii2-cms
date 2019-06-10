<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="form-box-dialog">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'layui-form'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item'],
            'labelOptions' => ['class' => 'layui-form-label','align'=>'right'],
            'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div><span class="help-block">{error}</span>',
        ]
    ]); ?>
    <?= $form->field($model, 'typename')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>
    <?= $form->field($model, 'order')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>
    <div class='layui-form-item'>
        <div class="layui-form-label"></div>
        <div class="layui-input-block">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
