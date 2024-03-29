<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AdPosition;

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
    <?= $form->field($model, 'ad_name')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'media_type')->dropDownList([0 => '图片',1 => '文字',2 => '代码'],['class'=>'layui-input','lay-filter'=>'media']) ?>
    <?= $form->field($model, 'position_id')->dropDownList(\yii\helpers\ArrayHelper::map(AdPosition::find()->asArray()->all(),'position_id','position_name'),['prompt' => '请选择']) ?>
    <?= $form->field($model, 'start_time',[
        'template' => '{label}<div class="layui-input-inline cal" style="width: 30%">{input}<i class="cus fa fa-calendar"></i></div><span class="help-block">{error}</span>',
    ])->textInput(['class'=>'layui-input','id'=>'sdt']) ?>
    <?= $form->field($model, 'end_time',[
        'template' => '{label}<div class="layui-input-inline cal" style="width: 30%">{input}<i class="cus fa fa-calendar"></i></div><span class="help-block">{error}</span>',
    ])->textInput(['class'=>'layui-input','id'=>'edt']) ?>

    <div class="media_url" style="display: <?php
        if($model->isNewRecord){
            echo 'block';
        }else{
            echo (in_array($model->media_type,[0,1])) ? 'block' : 'none';
        }
        ?>">
        <?= $form->field($model, 'ad_link')->textInput(['maxlength' => true,'class'=>'layui-input'])?>
    </div>

    <div class="media_img" style="display: <?php
        if($model->isNewRecord){
            echo 'block';
        }else{
            echo ($model->media_type == 0) ? 'block' : 'none';
        }
    ?>">
        <?= $form->field($model, 'img_link',[
            'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div><div class="layui-input-inline layui-btn-container" style="width: auto;"><button type="button" class="layui-btn layui-btn-primary upload_button" id="upload"><i class="layui-icon"></i>上传图片</button><a href="javascript:;" class="layui-btn layui-btn-primary" id="view_photo">查看图片</a></div>'
        ])->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    </div>

    <div class="media_font" style="display: <?php
    if($model->isNewRecord){
        echo 'none';
    }else{
        echo ($model->media_type == 1) ? 'block' : 'none';
    }
    ?>">
        <?= $form->field($model, 'font_content')->textInput(['class'=>'layui-input']) ?>
    </div>

    <div class="media_code" style="display: <?php
    if($model->isNewRecord){
        echo 'none';
    }else{
        echo ($model->media_type == 2) ? 'block' : 'none';
    }
    ?>">
        <?= $form->field($model,'code_content')->textarea(['class'=>'layui-textarea'])?>
    </div>

    <?= $form->field($model, 'status')->radioList([1=>'开启',0=>'关闭'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }]) ?>

    <?= $form->field($model, 'link_man')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'link_email')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'link_phone')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <div class='layui-form-item'>
        <div class="layui-form-label"></div>
        <div class="layui-input-block">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
