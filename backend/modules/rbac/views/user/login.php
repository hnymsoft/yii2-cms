<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

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
    <div class="message">后台管理系统 登录</div>
    <div id="darkbannerwrap"></div>
    <?php $form = ActiveForm::begin(['id' => 'login-form','options'=>['class' => 'layui-form']]); ?>
        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['class' => 'layui-input','placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['class' => 'layui-input','placeholder' => $model->getAttributeLabel('password')]) ?>

        <?php if($is_verify){?>
            <?php echo $form->field($dynamicModel, 'captcha')->widget(Captcha::className(), [
                'captchaAction' => '/site/captcha',
                'options' => [
                    'class' => 'layui-input',
                    'style' => 'width:110px;float:left',
                    'placeholder' => $dynamicModel->getAttributeLabel('captcha'),
                ],
                'template' => '
                   {input}&nbsp;&nbsp;{image}
                   ',
                'imageOptions' => [
                    'style' => 'cursor:pointer;',
                    'title' => '点击更换验证码'
                ]
            ])->label(false) ?>
            <hr class="hr15"/>
        <?php }?>

        <?= Html::submitButton("登 录", ['class' => 'layui-btn layui-btn-fluid login_btn','id'=>'login','lay-submit'=>'','name' => 'login-button']) ?>
        <hr class="hr15">
        <div class="layui-row">
            <div class="layui-col-md6">
                <?= $form->field($model, 'rememberMe',$fieldOptions3)->label(false)->checkbox(['class' => 'layui-input','lay-skin' => 'primary','title'=>'记住密码']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
