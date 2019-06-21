<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJs($this->render('js/_script.js'));
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body form-box-dialog">
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'layui-form','id'=>'form']
            ]); ?>
            <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                <ul class="layui-tab-title">
                    <li class="layui-this">系统配置</li>
                    <li>会员配置</li>
                    <li>邮件服务器配置</li>
                </ul>

                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <?php foreach($model AS $key => $val):?>
                            <?php if($val['group'] == 1):?>
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
                            <?php endif;?>
                        <?php endforeach; ?>

                        <div class='layui-form-item'>
                            <laybel class="layui-form-label"></laybel>
                            <div class="layui-input-block">
                                <?= Html::buttonInput('保存', ['class' => 'layui-btn','id'=>'btn','lay-submit'=>'','lay-filter'=>'go','data-url'=>\yii\helpers\Url::to(['index'])]) ?>
                            </div>
                        </div>

                    </div>

                    <div class="layui-tab-item">
                        <?php foreach($model AS $key => $val):?>
                            <?php if($val['group'] == 2):?>
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
                                            <input type="radio" name="<?=$val['item']?>" value="1" title="是" <?=$val['value'] == 1 ? 'checked':''?> />
                                            <input type="radio" name="<?=$val['item']?>" value="0" title="否" <?=$val['value'] == 0 ? 'checked':''?> />
                                        </div>
                                        <span class="help-block"><?=$val['info']?></span>
                                    </div>
                                <?php elseif ($val['type'] == 'select'):?>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><?=$val['name']?></label>
                                        <div class="layui-input-inline" style="width: 50%">
                                            <select name="<?=$val['item']?>">
                                                <option value=""></option>
                                                <option value="CKeditor" <?=$val['value'] == 'CKeditor'?'selected':''?>>CKeditor</option>
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
                            <?php endif;?>
                        <?php endforeach; ?>

                        <div class='layui-form-item'>
                            <laybel class="layui-form-label"></laybel>
                            <div class="layui-input-block">
                                <?= Html::buttonInput('保存', ['class' => 'layui-btn','id'=>'btn','lay-submit'=>'','lay-filter'=>'go','data-url'=>\yii\helpers\Url::to(['index'])]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="layui-tab-item">
                        <?php foreach($model AS $key => $val):?>
                            <?php if($val['group'] == 3):?>
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
                                            <input type="radio" name="<?=$val['item']?>" value="1" title="是" <?=$val['value'] == 1 ? 'checked':''?> />
                                            <input type="radio" name="<?=$val['item']?>" value="0" title="否" <?=$val['value'] == 0 ? 'checked':''?> />
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
                            <?php endif;?>
                        <?php endforeach; ?>

                        <div class='layui-form-item'>
                            <laybel class="layui-form-label"></laybel>
                            <div class="layui-input-block">
                                <?= Html::buttonInput('保存', ['class' => 'layui-btn','id'=>'btn','lay-submit'=>'','lay-filter'=>'go','data-url'=>\yii\helpers\Url::to(['index'])]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>