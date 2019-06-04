<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="search-box">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'layui-form layui-form-item'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-inline'],
            'labelOptions' => ['class' => 'layui-form-label'],
            'template' => '<div class="layui-inline">{label}<div class="layui-input-inline">{input}</div></div><span class="help-block" style="display: inline-block;">{hint}</span>',
        ],
    ]); ?>
    <?= $form->field($model, 'username')->textInput(['class'=>'layui-input search_input']) ?>
    <?= $form->field($model, 'email')->textInput(['class'=>'layui-input search_input']) ?>
    <div class="layui-inline">
        <?= Html::submitButton('查找用户', ['class' => 'layui-btn layui-btn-normal']) ?>
        <?= Html::a('添加用户',\yii\helpers\Url::to(['signup']), ['class' => "layui-btn layui-default-add"])?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
