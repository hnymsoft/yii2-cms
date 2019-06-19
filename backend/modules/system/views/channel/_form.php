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
    <div class="layui-form-item">
        <label class="layui-form-label">是否开启</label>
        <div class="layui-input-block">
            <input type="radio" name="Channel[status]" value="1" title="开启" <?php
            if($model->isNewRecord){
                echo 'checked';
            }else{
                if($model->status == 1){
                    echo 'checked';
                }
            }
            ?> />
            <input type="radio" name="Channel[status]" value="0" title="关闭" <?php
            if(!$model->isNewRecord){
                if($model->status == 0){
                    echo 'checked';
                }
            }
            ?> />
        </div>
    </div>

    <div class='layui-form-item'>
        <div class="layui-form-label"></div>
        <div class="layui-input-block">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
