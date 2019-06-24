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
    <?= $form->field($model, 'status')->radioList([1=>'是',0=>'否'],['item'=>function($index, $label, $name, $checked, $value){
        return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" lay-filter="flag" title="'.$label.'">';
    }]) ?>
    <div class='layui-form-item'>
        <div class="layui-form-label"></div>
        <div class="layui-input-block">
            <?= Html::submitButton('回复', ['class' => 'layui-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
