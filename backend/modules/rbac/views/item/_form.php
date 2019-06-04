<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use rbac\components\RouteRule;
use rbac\AutocompleteAsset;
use yii\helpers\Json;
use rbac\components\Configs;

$context = $this->context;
$labels = $context->labels();
$rules = Configs::authManager()->getRules();
unset($rules[RouteRule::RULE_NAME]);
$source = Json::htmlEncode(array_keys($rules));

$js = <<<JS
    $('#rule_name').autocomplete({
        source: $source,
    });
JS;
AutocompleteAsset::register($this);
$this->registerJs($js);
?>

<div class="form-box-dialog">
    <?php $form = ActiveForm::begin([
        'id' => 'item-form',
        'options' => ['class' => 'layui-form'],
        'fieldConfig' => [
            'options' => ['class' => 'layui-form-item'],
            'labelOptions' => ['class' => 'layui-form-label','align'=>'right'],
            'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div><span class="help-block">{error}</span>',
        ],
    ]); ?>
     
	<?= $form->field($model, 'name')->textInput(['maxlength' => 64,'class'=>'layui-input']) ?>

	<?= $form->field($model, 'description')->textarea(['rows' => 2,'class'=>'layui-textarea']) ?>

	<?= $form->field($model, 'ruleName')->textInput(['id' => 'rule_name','class'=>'layui-input']) ?>

	<?= $form->field($model, 'data')->textarea(['rows' => 6,'class'=>'layui-textarea']) ?>			
    <div class='layui-form-item'>
        <div class="layui-input-block">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', '添加') : Yii::t('rbac-admin', '编辑'), ['class' => $model->isNewRecord ? 'layui-btn' : 'layui-btn layui-btn-normal','name' => 'submit-button'])?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
