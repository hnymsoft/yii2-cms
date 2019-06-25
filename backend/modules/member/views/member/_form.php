<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJs($this->render('js/upload.js'));
?>

<div class="form-box-dialog">
    <?php $form = ActiveForm::begin([
        'id' => 'item-form',
        'options' => ['class' => 'layui-form'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item'],
            'labelOptions' => ['class' => 'layui-form-label','align'=>'right'],
            'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div>{hint}{error}',
        ],
    ]); ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true,'value'=>'','class'=>'layui-input']) ?>
    <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true,'value'=>'','class'=>'layui-input']) ?>
    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'head_pic',[
        'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div><div class="layui-input-inline layui-btn-container" style="width: auto;"><button type="button" class="layui-btn layui-btn-primary upload_button" id="upload"><i class="layui-icon"></i>上传头像</button><a href="javascript:;" class="layui-btn layui-btn-primary" id="view_photo">查看头像</a></div>'
    ])->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'email')->textInput(['type'=>'email','maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'r_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\MemberRank::find()->where(['status'=>1])->asArray()->all(),'id','name'),['prompt' => '请选择']) ?>

    <?= $form->field($model, 'integral')->textInput(['type'=>'number','class'=>'layui-input']) ?>
    <?= $form->field($model, 'balance')->textInput(['type'=>'number','maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'status')->radioList([10=>'启用',0=>'禁用'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }]) ?>
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
