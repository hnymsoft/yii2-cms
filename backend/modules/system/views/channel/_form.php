<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'm_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Module::find()->where(['status' => 1])->asArray()->all(),'id','name'),['prompt' => '请选择模型']) ?>
    <?= $form->field($model, 'p_id')->dropDownList(\yii\helpers\ArrayHelper::map($channelDropdown,'id','name')) ?>
    <?= $form->field($model, 'list_tpl')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'content_tpl')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'out_url')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'seo_keyword')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'seo_description')->textarea(['row' => 6,'class'=>'layui-textarea']) ?>
    <?= $form->field($model, 'order')->textInput(['class'=>'layui-input']) ?>
    <?= $form->field($model, 'status')->radioList([1=>'开启',0=>'关闭'],['item'=>function($index, $label, $name, $checked, $value){
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
