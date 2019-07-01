<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Collect */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-box-dialog">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'layui-form'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item layui-text'],
            'labelOptions' => ['class' => 'layui-form-label','align'=>'right','style'=>'width:120px'],
            'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div>{error}{hint}',
        ]
    ]); ?>

    <fieldset class="layui-elem-field layui-field-title">
        <legend>基础信息配置</legend>
    </fieldset>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>
    <?= $form->field($model,'encoding')->radioList([0=>'UTF-8',1=>'GB2312',2=>'BIG5'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }]) ?>
    <?= $form->field($model,'head')->radioList([0=>'否',1=>'是'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }])->label('移除HEAD')->hint('设置编码后仍然无法解决乱码，移除头部信息即可解决，启用后获取不到Html中head信息') ?>
    <?= $form->field($model,'reverse')->radioList([0=>'与目标站一致',1=>'与目标站相反'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }])->label('采集顺序') ?>

    <?= $form->field($model, 'referer')->textInput(['maxlength' => true,'class' => 'layui-input'])->label('引用网址')->hint('如果目标网站没有防盗链功能请不要开启，否则会降低采集速度') ?>
    <?= $form->field($model, 'status')->radioList([1=>'启用',0=>'禁用'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }]) ?>

    <blockquote class="layui-elem-quote layui-quote-nm">
        <legend>备注：标记选择器 就是 jQuery里面的选择器，基本上是完全通用的</legend>
    </blockquote>

    <fieldset class="layui-elem-field layui-field-title">
        <legend>列表网址获取规则</legend>
    </fieldset>

    <?= $form->field($model, 'list_url')->textInput(['maxlength' => true,'class' => 'layui-input'])->label('采集网址') ?>
    <?= $form->field($model, 'list_range')->textInput(['maxlength' => true,'class' => 'layui-input'])->label('区域开始') ?>
    <?= $form->field($model, 'list_rules_title')->textInput(['maxlength' => true,'class' => 'layui-input'])->label('标题匹配规则') ?>
    <?= $form->field($model, 'list_rules_url')->textInput(['maxlength' => true,'class' => 'layui-input'])->label('链接匹配规则') ?>
    <?= $form->field($model, 'list_rules_thumb')->textInput(['maxlength' => true,'class' => 'layui-input'])->label('缩图匹配规则') ?>

    <fieldset class="layui-elem-field layui-field-title">
        <legend>文章网址匹配规则</legend>
    </fieldset>

    <?= $form->field($model, 'content_rules_title')->textInput(['maxlength' => true,'class' => 'layui-input'])?>
    <?= $form->field($model, 'content_rules_kw')->textarea(['class' => 'layui-textarea'])?>
    <?= $form->field($model, 'content_rules_desc')->textarea(['class' => 'layui-textarea'])?>
    <?= $form->field($model, 'content_rules_content')->textarea(['class' => 'layui-textarea'])?>
    <?= $form->field($model, 'content_rules_author')->textInput(['maxlength' => true,'class' => 'layui-input'])?>
    <?= $form->field($model, 'content_rules_source')->textInput(['maxlength' => true,'class' => 'layui-input'])?>
    <?= $form->field($model, 'content_rules_click')->textInput(['maxlength' => true,'class' => 'layui-input'])?>
    <?= $form->field($model, 'content_rules_addtime')->textInput(['maxlength' => true,'class' => 'layui-input'])?>
    <div class='layui-form-item'>
        <div class="layui-form-label"></div>
        <div class="layui-input-block">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
