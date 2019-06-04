<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '管理登录';

$fieldOptions1 = [
    'options' => ['class' => 'layui-form-item'],
    'inputTemplate' => "{input}"
];

$fieldOptions2 = [
    'options' => ['class' => 'layui-form-item'],
    'inputTemplate' => "{input}"
];

$fieldOptions3 = [
    'options' => ['class' => 'layui-form-item','style'=>'height:40px'],
    'inputTemplate' => "{input}"
];
?>

<div class="login">
    <div class="message">WeAdmin 1.0-管理登录</div>
    <div id="darkbannerwrap"></div>
    <?php $form = ActiveForm::begin(['id' => 'login-form','options'=>['class' => 'layui-form'], 'enableClientValidation' => false]); ?>
        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['class' => 'layui-input','lay-verify'=>'required','placeholder' => $model->getAttributeLabel('username')]) ?>
        <hr class="hr15">
        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['class' => 'layui-input','lay-verify'=>'required','placeholder' => $model->getAttributeLabel('password')]) ?>
        <hr class="hr15">
        <?= Html::submitButton("登 录", ['class' => 'layui-btn layui-btn-fluid login_btn','lay-submit'=>'','name' => 'login-button']) ?>
        <hr class="hr15">
        <div class="layui-row">
            <div class="layui-col-md6">
                <?= $form->field($model, 'rememberMe',$fieldOptions3)->label(false)->checkbox(['class' => 'layui-input','lay-skin' => 'primary','title'=>'记住密码']) ?>
            </div>
            <div class="layui-col-md6" align="right">
                <?= Html::a('忘记密码', ['/rbac/user/request-password-reset'], ['class' => 'layui-text','style'=>'line-height:60px']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
