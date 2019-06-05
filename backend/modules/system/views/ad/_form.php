<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AdPosition;

$this->registerJs($this->render('js/_script.js'));
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
        <div id="thumb_box" style="display: <?php
            if($model->isNewRecord){
                echo 'none';
            }else{
                isset($model->media_type) ? 'block' : 'none';
            }
            ?>">
            <?= Html::img(@$model->ad_code, ['id'=>'thumb','style'=>'margin:0 0 15px 130px;','width'=>'115','height'=>'80'])?>
        </div>
        <?= $form->field($model, 'img_upload',[
            'template' => '{label}{input}<div class="layui-input-inline" style="width: 50px;"><button type="button" class="layui-btn layui-btn-primary upload_button" id="test3"><i class="layui-icon"></i>上传文件</button>{hint}</div>'
        ])->hiddenInput(['maxlength' => true,'class'=>'layui-input upload_input']) ?>
        <?= $form->field($model, 'img_link')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    </div>

    <div class="media_font" style="display: <?=$model->media_type == 1 ? 'block': 'none' ?>">
        <?= $form->field($model, 'font_content')->textInput(['rows' => 6,'class'=>'layui-input']) ?>
    </div>

    <div class="media_code" style="display: <?=$model->media_type == 2 ? 'block': 'none' ?>">
        <?= $form->field($model,'code_content')->textarea(['class'=>'layui-textarea'])?>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">是否开启</label>
        <div class="layui-input-block">
            <input type="radio" name="Ad[enabled]" value="1" title="开启" <?php
                if($model->isNewRecord){
                    echo 'checked';
                }else{
                    if($model->enabled == 1){
                        echo 'checked';
                    }
                }
            ?> />
            <input type="radio" name="Ad[enabled]" value="0" title="关闭" <?php
            if(!$model->isNewRecord){
                if($model->enabled == 0){
                    echo 'checked';
                }
            }
            ?> />
        </div>
    </div>
    <?= $form->field($model, 'link_man')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'link_email')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <?= $form->field($model, 'link_phone')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
    <div class='layui-form-item'>
        <div class="layui-form-label"></div>
        <div class="layui-input-block">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => $model->isNewRecord ? 'layui-btn' : 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
