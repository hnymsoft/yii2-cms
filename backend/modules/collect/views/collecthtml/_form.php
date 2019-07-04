<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="form-box-dialog">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'layui-form layui-text'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item'],
            'labelOptions' => ['class' => 'layui-form-label','style'=>'width:120px'],
            'template' => '{label}<div class="layui-input-block" style="margin-left: 150px;">{input}</div>{error}{hint}',
        ]
    ]); ?>

    <?= $form->field($model, 'ext_title')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>
    <?= $form->field($model, 'ext_content')->textarea(['class' => 'layui-textarea','style'=>'height:400px;']) ?>
    <?= $form->field($model, 'ext_keyword')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>
    <?= $form->field($model, 'ext_description')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>
    <?= $form->field($model, 'ext_source')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>
    <?= $form->field($model, 'ext_click')->textInput(['type' => 'number','class' => 'layui-input']) ?>
    <?= $form->field($model, 'ext_author')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>

    <div class='layui-form-item'>
        <div class="layui-form-label" style="width: 120px;"></div>
        <div class="layui-input-block" style="margin-left: 150px;">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<style>
    .form-box-dialog .help-block, .form-box-dialog .hint-block{left:150px;}
    .form-box-dialog .field-collect-is_head .help-block, .form-box-dialog .field-collect-is_head .hint-block,.form-box-dialog .field-collect-is_thumb .help-block, .form-box-dialog .field-collect-is_thumb .hint-block{left:0;}
</style>
