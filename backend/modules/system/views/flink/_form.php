<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJs($this->render('js/_script.js'));
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

    <?= $form->field($model, 'webname')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>

    <?= $form->field($model, 'linkurl')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>

    <?= $form->field($model, 'logo',[
        'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div><div class="layui-input-inline layui-btn-container" style="width: auto;"><button type="button" class="layui-btn layui-btn-primary upload_button" id="upload"><i class="layui-icon"></i>上传图片</button><a href="javascript:;" class="layui-btn layui-btn-primary" id="view_photo">查看图片</a></div>'
    ])->textInput(['maxlength' => true,'class'=>'layui-input']) ?>

    <?= $form->field($model, 'typeid')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Flinktype::find()->orderBy('order asc')->asArray()->all(),'id','typename')) ?>

    <?= $form->field($model, 'introduce')->textarea(['row' => 6,'class' => 'layui-textarea']) ?>

    <?= $form->field($model, 'order')->textInput(['class'=>'layui-input']) ?>

    <div class="layui-form-item">
        <label class="layui-form-label">是否开启</label>
        <div class="layui-input-block">
            <input type="radio" name="Flink[status]" value="1" title="通过" <?php
            if($model->isNewRecord){
                echo 'checked';
            }else{
                if($model->status == 1){
                    echo 'checked';
                }
            }
            ?> />
            <input type="radio" name="Flink[status]" value="0" title="待审" <?php
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
