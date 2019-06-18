<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?= DetailView::widget([
    'model' => $model,
    'options' => ['class' => 'layui-table','lay-skin'=>'nob','style'=>'width:100%;margin:15px auto 30px'],
    'template' => '<tr><th width="90px;">{label}</th><td>{value}</td></tr>',
    'attributes' => [
        'subject',
        'name',
        'mobile',
        [
            'label' => '留言内容',
            'format' => 'raw',
            'value' => function($model){
                return "{$model->content}";
            }
        ],
        'addtime',
    ],
]) ?>

<div class="guestbook-form">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'layui-form'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item'],
            'labelOptions' => ['class' => 'layui-form-label','align'=>'right'],
            'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div><span class="help-block">{error}</span>',
        ],
    ]); ?>
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'reply')->textarea(['class'=>'layui-textarea','row'=>6]) ?>
    <div class="layui-form-item">
        <label class="layui-form-label">是否前台显示</label>
        <div class="layui-input-block">
            <input type="radio" name="Guestbook[status]" value="1" title="是" <?php
            if($model->isNewRecord){
                echo 'checked';
            }else{
                if($model->status == 1){
                    echo 'checked';
                }
            }
            ?> />
            <input type="radio" name="Guestbook[status]" value="0" title="否" <?php
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
            <?= Html::submitButton('回复', ['class' => 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
