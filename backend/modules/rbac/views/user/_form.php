<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJs($this->render('js/upload.js'));
?>

<div class="form-box-dialog">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'layui-form'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item'],
            'labelOptions' => ['class' => 'layui-form-label','align'=>'right'],
            'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div><span class="help-block">{error}</span>',
        ],
    ]); ?>
	
    <?= $form->field($model, 'username')->textInput(['maxlength' => true,'class'=>'layui-input','readonly'=>!isset($model->isNewRecord) ? false : true]) ?>
	<?= $form->field($model, 'nickname')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= Html::img(@$model->head_pic, ['style'=>'margin-left:130px;margin-bottom:10px;','width'=>'50','height'=>'50','class'=>'layui-circle userinfo_head_pic'])?>
	<?= $form->field($model, 'head_pic',[
	        'template' => '{label}{input}<div class="layui-input-inline" style="width: 50px;"><button type="button" class="layui-btn layui-btn-primary upload_button" id="test3"><i class="layui-icon"></i>上传头像</button>{hint}</div>'
    ])->hiddenInput(['maxlength' => true,'class'=>'layui-input upload_input']) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, !isset($model->isNewRecord) ? 'password':'password_hash')->passwordInput(['maxlength' => true,'value'=>'','class'=>'layui-input']) ?>
    <div class='layui-form-item'>
        <div class="layui-form-label"></div>
        <div class="layui-input-block">
            <?= Html::submitButton(!isset($model->isNewRecord) ? '添加' : '编辑', ['class' => !isset($model->isNewRecord) ? 'layui-btn' : 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

