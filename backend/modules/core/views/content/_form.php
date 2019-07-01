<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJs($this->render('js/_script.js'));
?>

<div class="form-box-dialog">
    <?php $form = ActiveForm::begin([
        'id' => 'item-form',
        'options' => ['class' => 'layui-form layui-text'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item'],
            'labelOptions' => ['class' => 'layui-form-label','align'=>'right'],
            'template' => '{label}<div class="layui-input-inline" style="width: 35%">{input}</div>{hint}{error}',
        ],
    ]); ?>
    <div class="layui-tab">
        <ul class="layui-tab-title" style="margin-bottom: 10px;">
            <li class="layui-this">常规内容</li>
            <li>高级参数</li>
        </ul>

        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
                <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
                <?= $form->field($model, 'flag')->checkboxList(['t'=>'置顶','c'=>'推荐','h'=>'头条','r'=>'跳转'],['item'=>function($index, $label, $name, $checked, $value){
                    return '<input type="checkbox" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
                }]) ?>
                <div id="redirect" style="display: <?=isset($model->flag) && in_array('r',$model->flag) ? 'block': 'none'?>">
                    <?= $form->field($model, 'out_url')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
                </div>
                <?= $form->field($model, 'thumb',[
                    'template' => '{label}<div class="layui-input-inline" style="width: 35%">{input}</div>{hint}{error}<div class="layui-input-inline layui-btn-container" style="width: auto;"><button type="button" class="layui-btn upload_button" id="upload"><i class="layui-icon"></i>上传图片</button><a href="javascript:;" class="layui-btn" id="view_photo">预览图片</a></div>'
                ])->textInput(['maxlength' => true,'class'=>'layui-input','placeholder'=>'请上传缩略图或使用网络图片且必须以 http://（https://）开头']) ?>
                <?= $form->field($model, 'p_id')->dropDownList(\yii\helpers\ArrayHelper::map($channelDropdown,'id','name')) ?>
                <?= $form->field($model, 'keywords')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>
                <?= $form->field($model, 'description')->textarea(['row' => 6,'class'=>'layui-textarea']) ?>
                <!--附加模型字段-->
                    <?php if($model->m_id == 3): //产品?>
                        <?= $form->field($attachTableModel, 'price')->textInput(['type' => 'number','class'=>'layui-input'])->label('价格') ?>
                        <?= $form->field($attachTableModel, 'cost_price')->textInput(['type' => 'number','class'=>'layui-input'])->label('原价') ?>
                        <?= $form->field($attachTableModel, 'brand')->textInput(['maxlength' => true,'class'=>'layui-input'])->label('品牌') ?>
                        <?= $form->field($attachTableModel, 'brand')->textInput(['units' => true,'class'=>'layui-input'])->label('单位') ?>
                    <?php elseif ($model->m_id == 2): //图片?>
                        <div class='layui-form-item'>
                            <div class="layui-form-label"></div>
                            <div class="layui-input-block">
                                <div class="layui-upload">
                                    <button type="button" class="layui-btn" id="batUpload">多图片上传</button>
                                    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                        预览图：
                                        <?php if($attachTableModel->isNewRecord):?>
                                            <div class="layui-upload-list" id="batUploadList"></div>
                                        <?php else:?>
                                            <div class="layui-upload-list" id="batUploadList">
                                                <?php if(!empty($thumb_list)):?>
                                                    <?php foreach ($thumb_list AS $val):?>
                                                        <div><img src="/<?=$val?>" alt="图集" class="layui-upload-img"><span data-src="<?=$val?>">删除</span></div>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </div>
                                        <?php endif;?>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <?= Html::activeHiddenInput($attachTableModel,'imgurls')?>
                    <?php endif;?>

                    <!--附加模型扩展字段-->
                    <?= $this->render('_field',[
                        'form' => $form,
                        'extend_filed' => $extend_filed,
                        'attachTableModel' => $attachTableModel
                    ]) ?>
                    <!--附加模型扩展字段-->

                    <div class='layui-form-item'>
                        <div class="layui-form-label">内容</div>
                        <div class="layui-input-block">
                            <?= $this->render('_editor',['attachTableModel' => $attachTableModel]) ?>
                        </div>
                    </div>
                <!--附加模型字段-->
                <?= $form->field($model, 'tags')->textInput(['maxlength' => true,'class'=>'layui-input'])->hint('文章tag，英文逗号隔开') ?>
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
                <?= $form->field($model, 'color',[
                    'template' => '{label}<div class="layui-input-inline" style="width: 35%">{input}</div>{hint}{error}<div class="layui-input-inline" id="title_color"></div>'
                ])->textInput(['maxlength' => true,'class'=>'layui-input','id'=>'input_title_color']) ?>
                <?= $form->field($model, 'pubdate_addtime',[
                    'template' => '{label}<div class="layui-input-inline cal" style="width: 35%;">{input}<i class="cus fa fa-calendar"></i></div>{hint}<span class="help-block">{error}</span>',
                ])->textInput(['class'=>'layui-input','id'=>'pubdate_addtime']) ?>

                <?= $form->field($attachTableModel, 'templet')->textInput(['maxlength' => true,'class'=>'layui-input'])->label('自定义路径') ?>
                <?= $form->field($model, 'status')->radioList(['待审核','通过'],['item'=>function($index, $label, $name, $checked, $value){
                    return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' title="'.$label.'">';
                }]) ?>

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
