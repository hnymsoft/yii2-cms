<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'layui-input']) ?>

    <?= $form->field($model, 'score')->textInput(['class'=>'layui-input']) ?>

    <?= $form->field($model, 'discount')->textInput(['class'=>'layui-input'])->hint('折扣（百分比）') ?>

    <div class="layui-form-item">
        <label class="layui-form-label">是否启用</label>
        <div class="layui-input-block">
            <input type="radio" name="MemberRank[status]" value="1" title="是" <?php
            if($model->isNewRecord){
                echo 'checked';
            }else{
                if($model->status == 1){
                    echo 'checked';
                }
            }
            ?> />
            <input type="radio" name="MemberRank[status]" value="0" title="否" <?php
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

    <?php ActiveForm::end(); ?>

</div>
