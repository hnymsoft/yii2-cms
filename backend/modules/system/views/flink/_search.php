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

    <?= $form->field($model, 'webname')->textInput(['class'=>'layui-input search_input']) ?>
    <?= $form->field($model, 'typeid')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Flinktype::find()->orderBy('order asc')->asArray()->all(),'id','typename')) ?>

    <div class="layui-inline btn-group">
        <?= Html::submitButton('搜索', ['class' => 'layui-btn']) ?>
        <?= Html::a('添加',\yii\helpers\Url::to(['create']), ['class' => "layui-btn layui-btn-primary layui-default-add"])?>
        <?= Html::a('分类管理',\yii\helpers\Url::to(['flinktype/index']), ['class' => "layui-btn layui-btn-primary layui-default-add"])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
