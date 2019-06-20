<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="form-box-dialog">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'layui-form'],
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
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" name="Module[status]" value="1" title="启用" <?php
                if($model->isNewRecord){
                    echo 'checked';
                }else{
                    if($model->status == 1){
                        echo 'checked';
                    }
                }
                ?> />
                <input type="radio" name="Module[status]" value="0" title="禁用" <?php
                if(!$model->isNewRecord){
                    if($model->status == 0){
                        echo 'checked';
                    }
                }
                ?> />
            </div>
        </div>

        <div class='layui-form-item'>
            <div class="layui-form-label"></div>
            <div class="layui-input-block">
                <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'layui-btn']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
