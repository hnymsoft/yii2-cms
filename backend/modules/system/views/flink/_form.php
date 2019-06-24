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
    <?= $form->field($model, 'status')->radioList([1=>'通过',0=>'待审'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }]) ?>
    <div class='layui-form-item'>
        <div class="layui-form-label"></div>
        <div class="layui-input-block">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
