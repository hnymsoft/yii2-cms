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
        ]
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['class' => 'layui-input']) ?>
    <?= $form->field($model, 'item')->textInput(['class' => 'layui-input']) ?>
    <?= $form->field($model, 'm_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Module::find()->where([])->asArray()->all(),'id','name')) ?>
    <div class="layui-inline">
        <?= Html::submitButton('搜索', ['class' => 'layui-btn layui-btn-normal']) ?>
        <?= Html::a('添加字段',\yii\helpers\Url::to(['create']), ['class' => "layui-btn layui-default-add"])?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
