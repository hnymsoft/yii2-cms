<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="form-box-dialog">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'layui-form layui-text'],
        'enableAjaxValidation' => $model->isNewRecord ? true : false,
        'validationUrl' => \yii\helpers\Url::toRoute(['check-table-unique']),
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item'],
            'labelOptions' => ['class' => 'layui-form-label','align'=>'right'],
            'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div><span class="help-block">{error}</span>',
        ],
    ]); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
        <?php if($model->isNewRecord):?>
            <?= $form->field($model, 'attach_table')->textInput(['maxlength' => true,'class'=>'layui-input','placeholder'=>'必须由英文、数字、下划线组成  例：attach_extend1']) ?>
        <?php else:?>
            <?= $form->field($model, 'attach_table')->textInput(['maxlength' => true,'class'=>'layui-input','placeholder'=>'必须由英文、数字、下划线组成  例：attach_extend1','readonly'=>'']) ?>
        <?php endif;?>
        <?= $form->field($model, 'list_tpl')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
        <?= $form->field($model, 'content_tpl')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
        <?= $form->field($model, 'status')->radioList([1=>'启用',0=>'禁用'],['item'=>function($index, $label, $name, $checked, $value){
            return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
        }]) ?>
        <div class='layui-form-item'>
            <div class="layui-form-label"></div>
            <div class="layui-input-block">
                <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'layui-btn']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
