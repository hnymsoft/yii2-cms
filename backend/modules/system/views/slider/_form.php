<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJs($this->render('js/_script.js'));
?>
<div class="form-box-dialog">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'layui-form layui-text'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item'],
            'labelOptions' => ['class' => 'layui-form-label','align'=>'right'],
            'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div><span class="help-block">{error}</span>',
        ],
    ]); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'link')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'pic',[
        'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div>{hint}{error}<div class="layui-input-inline layui-btn-container" style="width: auto;"><button type="button" class="layui-btn upload_button" id="upload"><i class="layui-icon"></i>上传图片</button><a href="javascript:;" class="layui-btn" id="view_photo">预览图片</a></div>'
    ])->textInput(['maxlength' => true,'class'=>'layui-input','placeholder'=>'请上传缩略图或使用网络图片且必须以 http://（https://）开头']) ?>
    <?= $form->field($model, 'order')->textInput(['type'=>'number','class'=>'layui-input']) ?>
    <?= $form->field($model, 'status')->radioList([1=>'启用',0=>'禁用'],['item'=>function($index, $label, $name, $checked, $value){
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
