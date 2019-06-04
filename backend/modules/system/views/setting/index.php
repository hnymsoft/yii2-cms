<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">系统设置</div>
        <div class="layui-card-body form-box-dialog">
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'layui-form','id'=>'form']
            ]); ?>
            <?php foreach($model AS $key => $val):?>
                <?php if ($val['type'] == 'textarea'):?>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?=$val['name']?></label>
                        <div class="layui-input-inline" style="width: 50%">
                            <textarea name="<?=$val['item']?>" class="layui-textarea" lay-verify="<?=$val['item']?>"><?=$val['value']?></textarea>
                        </div>
                        <span class="help-block"><?=$val['info']?></span>
                    </div>
                <?php elseif ($val['type'] == 'radio'):?>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?=$val['name']?></label>
                        <div class="layui-input-inline" style="width: 50%">
                            <input type="radio" name="<?=$val['item']?>" value="1" title="开启" <?=$val['value'] == 1 ? 'checked':''?> />
                            <input type="radio" name="<?=$val['item']?>" value="0" title="关闭" <?=$val['value'] == 0 ? 'checked':''?> />
                        </div>
                        <span class="help-block"><?=$val['info']?></span>
                    </div>
                <?php elseif ($val['type'] == 'select'):?>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?=$val['name']?></label>
                        <div class="layui-input-inline" style="width: 50%">
                            <select name="<?=$val['item']?>">
                                <option value=""></option>
                                <option value="FCKeditor" <?=$val['value'] == 'FCKeditor'?'selected':''?>>FCKeditor</option>
                                <option value="UEditor" <?=$val['value'] == 'UEditor'?'selected':''?>>UEditor</option>
                            </select>
                        </div>
                        <span class="help-block"><?=$val['info']?></span>
                    </div>
                <?php else:?>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?=$val['name']?></label>
                        <div class="layui-input-inline" style="width: 50%">
                            <input type="text" name="<?=$val['item']?>" value="<?=$val['value']?>" class="layui-input"  autocomplete="off"  lay-verify="<?=$val['verify']?>" lay-verType="tips" />
                        </div>
                        <span class="help-block"><?=$val['info']?></span>
                    </div>
                <?php endif;?>
            <?php endforeach; ?>

            <div class='layui-form-item'>
                <div class="layui-input-block">
                    <?= Html::buttonInput('提交', ['class' => 'layui-btn','id'=>'btn','lay-submit'=>'','lay-filter'=>'go','data-url'=>\yii\helpers\Url::to(['index'])]) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>