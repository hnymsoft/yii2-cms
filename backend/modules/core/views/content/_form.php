<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJs($this->render('js/_script.js'));
?>

<div class="form-box-dialog">
    <?php $form = ActiveForm::begin([
        'id' => 'item-form',
        'options' => ['class' => 'layui-form'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item'],
            'labelOptions' => ['class' => 'layui-form-label','align'=>'right'],
            'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div>{hint}{error}',
        ],
    ]); ?>
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title">
            <li class="layui-this">基本内容</li>
            <li>高级内容</li>
        </ul>

        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
                <div class="layui-form-item">
                    <label class="layui-form-label">自定义属性</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="Content[flag]" value="1" title="置顶"/>
                        <input type="checkbox" name="Content[flag]" value="0" title="推荐"/>
                        <input type="checkbox" name="Content[flag]" value="0" title="头条"/>
                        <input type="checkbox" name="Content[flag]" value="0" title="跳转"/>
                    </div>
                </div>

                <div class="media_img" style="display: <?php
                if($model->isNewRecord){
                    echo 'block';
                }else{
                    echo ($model->media_type == 0) ? 'block' : 'none';
                }
                ?>">
                    <?= $form->field($model, 'thumb',[
                        'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div>{hint}{error}<div class="layui-input-inline layui-btn-container" style="width: auto;"><button type="button" class="layui-btn upload_button" id="upload"><i class="layui-icon"></i>上传图片</button><a href="javascript:;" class="layui-btn" id="view_photo">预览图片</a></div>'
                    ])->textInput(['maxlength' => true,'class'=>'layui-input','placeholder'=>'请上传缩略图或使用网络图片且必须以 http://（https://）开头']) ?>
                </div>
                <!--扩展字段-->
                <?= $this->render('_field',[
                    'form' => $form,
                    'extend_filed' => $extend_filed

                ]) ?>
                <!--扩展字段-->

                <?= $form->field($model, 'tags')->textInput(['maxlength' => true,'class'=>'layui-input'])->hint('文章tag，英文逗号隔开') ?>
                <?= $form->field($model, 'p_id')->dropDownList(\yii\helpers\ArrayHelper::map($channelDropdown,'id','name')) ?>
                <?php if($model->m_id == 3):?>
                    <?= $form->field($model, 'money')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
                <?php endif;?>
                <?= $form->field($model, 'author')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
                <?= $form->field($model, 'source')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
                <?= $form->field($model, 'click')->textInput(['type'=>'number','class'=>'layui-input']) ?>

                <div class='layui-form-item'>
                    <div class="layui-form-label"></div>
                    <div class="layui-input-block">
                        <?=
                        Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', '添加') : Yii::t('rbac-admin', '编辑'), ['class' => $model->isNewRecord? 'layui-btn' : 'layui-btn layui-btn-normal'])
                        ?>
                    </div>
                </div>
            </div>
            <div class="layui-tab-item">
                <?= $form->field($model, 'color')->textInput(['id'=>'test-form-input','maxlength' => true,'class'=>'layui-input']) ?>
                <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
                <?= $form->field($model, 'keywords')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
                <?= $form->field($model, 'description')->textarea(['row' => 6,'class'=>'layui-textarea']) ?>
                <?= $form->field($model, 'pubdate_addtime',[
                    'template' => '{label}<div class="layui-input-inline cal" style="width: 30%">{input}<i class="cus fa fa-calendar"></i></div>{hint}<span class="help-block">{error}</span>',
                ])->textInput(['class'=>'layui-input','id'=>'pubdate_addtime'])->hint('设置未来时间可定时发布！') ?>
                <div class="layui-form-item">
                    <label class="layui-form-label">阅读权限</label>
                    <div class="layui-input-block">
                        <input type="radio" name="Content[status]" value="1" title="通过" <?php
                        if($model->isNewRecord){
                            echo 'checked';
                        }else{
                            if($model->status == 10){
                                echo 'checked';
                            }
                        }
                        ?> />
                        <input type="radio" name="Content[status]" value="0" title="待审核" <?php
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
                        <?=
                        Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', '添加') : Yii::t('rbac-admin', '编辑'), ['class' => $model->isNewRecord? 'layui-btn' : 'layui-btn layui-btn-normal'])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>
