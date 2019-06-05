<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use rbac\models\Menu;
use yii\helpers\Json;
use rbac\AutocompleteAsset;

/* @var $this yii\web\View */
/* @var $model rbac\models\Menu */
/* @var $form yii\widgets\ActiveForm */
AutocompleteAsset::register($this);
$opts = Json::htmlEncode([
        'menus' => Menu::getMenuSource(),
        'routes' => Menu::getSavedRoutes(),
    ]);
$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('js/_script.js'));
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
    <?= Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?>
	
	<?= $form->field($model, 'name')->textInput(['maxlength' => 128,'class'=>'layui-input']) ?>

	<?= $form->field($model, 'parent_name')->textInput(['id' => 'parent_name','class'=>'layui-input']) ?>

	<?= $form->field($model, 'route')->textInput(['id' => 'route','class'=>'layui-input']) ?>
	
	<?= $form->field($model, 'order')->input('number',['class'=>'layui-input']) ?>

    <?= $form->field($model, 'icon',[
	        'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div><div class="layui-input-inline" style="width: 50px;"><button type="button" class="layui-btn layui-btn-primary open-icon">选择图标</button></div>'
    ])->textInput(['maxlength' => true,'class'=>'layui-input']) ?>

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
