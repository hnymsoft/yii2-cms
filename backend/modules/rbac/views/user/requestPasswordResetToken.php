<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '找回密码 - 管理登录';

$fieldOptions1 = [
    'options' => ['class' => 'layui-form-item'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];
?>

<div class="login">
    <h1 class="subject">找回密码</h1>
    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form','options'=>['class' => 'layui-form'], 'enableClientValidation' => false]); ?>
        <?= $form
            ->field($model, 'email', $fieldOptions1)
            ->label(false)
            ->textInput(['class' => 'layui-input','placeholder' => $model->getAttributeLabel('email')]) ?>
        <?= Html::submitButton("发送邮件", ['class' => 'layui-btn layui-btn-fluid login_btn','lay-submit'=>'','name' => 'login-button']) ?>
    <?php ActiveForm::end(); ?>
</div>

