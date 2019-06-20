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
            'template' => '{label}<div class="layui-input-inline" style="width: 40%">{input}</div><span class="help-block">{error}</span>{hint}',
        ],
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>
    <?= $form->field($model, 'item')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder' => '请输入字段名称,字母、下划线，如：price、am_price']) ?>
    <?= $form->field($model, 'desc')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>
    <?= $form->field($model, 'm_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Module::find()->where([])->asArray()->all(),'id','name'),['prompt' => '请选择模型']) ?>
    <?= $form->field($model, 'f_type')->dropDownList(\common\models\ExtField::$input_type,['prompt' => '请选择字段类型']) ?>
    <?= $form->field($model, 'value')->textarea(['row' => 6,'class' => 'layui-textarea','placeholder' => '多个选项用逗号或回车隔开'])->hint('只在类型为单选或多选时填写有效，多个选项用逗号或回车隔开。') ?>
    <?= $form->field($model, 'order')->textInput(['type' => 'number','class' => 'layui-input']) ?>
    <div class='layui-form-item'>
        <div class="layui-form-label"></div>
        <div class="layui-input-block">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
