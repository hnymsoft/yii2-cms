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
            'labelOptions' => ['class' => 'layui-form-label','style'=>'width:120px'],
            'template' => '{label}<div class="layui-input-block" style="margin-left: 150px;">{input}</div>{error}{hint}',
        ]
    ]); ?>

    <fieldset class="layui-elem-field layui-field-title">
        <legend>基础信息配置</legend>
    </fieldset>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>
    <?= $form->field($model,'encoding')->radioList([0=>'UTF-8',1=>'GB2312',2=>'BIG5'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }]) ?>
    <?= $form->field($model,'is_head',['template'=>'
    {label}<div class="layui-input-block" style="width:200px;margin-left: 0;float: left;">{input}</div>{error}{hint}
    '])->radioList([0=>'否',1=>'是'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }])->hint('警告：编码设置后采集还显示乱码，可开启该功能，既可解决编码乱码问题。但开启后将获取不到head标签中的数据，请谨慎操作。')?>
    <?= $form->field($model,'is_ref')->radioList([0=>'否',1=>'是'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="is_ref" title="'.$label.'">';
    }])?>
    <div id="is_ref_url" style="display: <?=$model->is_ref == 1 ? 'block': 'none'?>">
    <?= $form->field($model, 'is_ref_url')->textInput(['maxlength' => true,'class' => 'layui-input'])->label('引用网址')->hint('如果目标网站没有防盗链功能请不要开启，否则会降低采集速度') ?>
    </div>

    <?= $form->field($model,'is_reverse')->radioList([0=>'与采集站一致',1=>'与采集站相反'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }])?>
    <?= $form->field($model,'is_thumb',['template'=>'
    {label}<div class="layui-input-block" style="width:200px;margin-left: 0;float: left;">{input}</div>{error}{hint}
    '])->radioList([0=>'否',1=>'是'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }])->hint('提取内容第一张图片为文章缩略图！')?>
    <?= $form->field($model, 'timeout')->textInput(['maxlength' => true,'class' => 'layui-input']) ?>
    <?= $form->field($model,'status')->radioList([0=>'禁用',1=>'启用'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }])?>

    <blockquote class="layui-elem-quote">
        备注：
        <br>下方所有匹配规则、过滤规则，均支持Jquery语法。详情请点击 <a href="javascript:;" id="open-jqdoc">Jquery参考</a>。过滤某元素前加‘-’号，多个过滤规则使用英文逗号分隔开。
    </blockquote>

    <fieldset class="layui-elem-field layui-field-title" style="margin:30px 0">
        <legend>列表区域规则</legend>
    </fieldset>

    <?= $form->field($model, 'list_url')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'请输入采集网址 例：http://www.xxx.com/news/list.htm']) ?>
    <?= $form->field($model, 'list_range')->textarea(['row' => 6,'class' => 'layui-textarea','placeholder'=>'例：.list_arc li'])?>
    <?= $form->field($model, 'list_rules_title')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：h2 a'])?>
    <?= $form->field($model, 'list_rules_url')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：h2 a'])?>
    <?= $form->field($model, 'list_rules_thumb')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：img.thumb'])?>

    <fieldset class="layui-elem-field layui-field-title" style="margin:30px 0">
        <legend>文章区域规则</legend>
    </fieldset>
    <?= $form->field($model, 'content_range')->textarea(['row' => 6,'class' => 'layui-textarea','placeholder'=>'例：.content_arc'])?>
    <?= $form->field($model, 'content_rules_title')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：h1.subject'])?>
    <?= $form->field($model, 'content_rules_kw')->textarea(['row'=>6,'class' => 'layui-textarea','placeholder'=>'例：meta[name=keyword]'])?>
    <?= $form->field($model, 'content_rules_desc')->textarea(['row'=>6,'class' => 'layui-textarea','placeholder'=>'例：meta[name=description]'])?>
    <fieldset class="layui-elem-field layui-field-title" style="margin:30px 0;">
        <legend style="font-size: 16px;">文章内容</legend>
    </fieldset>
    <?= $form->field($model, 'content_rules_content')->textarea(['row'=>6,'class' => 'layui-textarea','placeholder'=>'例：div.arc_content'])->label('匹配规则')?>
    <?= $form->field($model, 'content_rules_content_filter')->textarea(['row'=>6,'class' => 'layui-textarea','placeholder'=>'例：-div strong,-div small'])->label('过滤规则')?>
    <fieldset class="layui-elem-field layui-field-title" style="margin:30px 0;">
        <legend style="font-size: 16px;">文章作者</legend>
    </fieldset>
    <?= $form->field($model, 'content_rules_author')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：div h2 span.author'])->label('匹配规则')?>
    <?= $form->field($model, 'content_rules_author_filter')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：-div strong,-div small'])->label('过滤规则')?>
    <fieldset class="layui-elem-field layui-field-title" style="margin:30px 0;">
        <legend style="font-size: 16px;">文章来源</legend>
    </fieldset>
    <?= $form->field($model, 'content_rules_source')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：div h2 span.source'])->label('匹配规则')?>
    <?= $form->field($model, 'content_rules_source_filter')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：-div strong,-div small'])->label('过滤规则')?>
    <fieldset class="layui-elem-field layui-field-title" style="margin:30px 0;">
        <legend style="font-size: 16px;">文章点击量</legend>
    </fieldset>
    <?= $form->field($model, 'content_rules_click')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：div h2 span.click'])->label('匹配规则')?>
    <?= $form->field($model, 'content_rules_click_filter')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：-div strong,-div small'])->label('过滤规则')?>
    <fieldset class="layui-elem-field layui-field-title" style="margin:30px 0;">
        <legend style="font-size: 16px;">文章发布时间</legend>
    </fieldset>
    <?= $form->field($model, 'content_rules_addtime')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：div h2 span.datetime'])->label('匹配规则')?>
    <?= $form->field($model, 'content_rules_addtime_filter')->textInput(['maxlength' => true,'class' => 'layui-input','placeholder'=>'例：-div strong,-div small'])->label('过滤规则')?>
    <div class='layui-form-item'>
        <div class="layui-form-label" style="width: 120px;"></div>
        <div class="layui-input-block" style="margin-left: 150px;">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<style>
.form-box-dialog .help-block, .form-box-dialog .hint-block{left:150px;}
.form-box-dialog .field-collect-is_head .help-block, .form-box-dialog .field-collect-is_head .hint-block,.form-box-dialog .field-collect-is_thumb .help-block, .form-box-dialog .field-collect-is_thumb .hint-block{left:0;}
</style>
