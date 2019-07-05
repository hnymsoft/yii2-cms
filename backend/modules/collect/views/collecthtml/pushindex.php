<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['breadcrumbs'][] = ['label' => '采集管理','url'=>\yii\helpers\Url::toRoute(['collect/index'])];
$this->params['breadcrumbs'][] = ['label' => '临时内容列表','url'=>\yii\helpers\Url::toRoute(['collecthtml/index'])];
$this->params['breadcrumbs'][] = '入库';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">临时内容入库</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
        <div class="form-box-dialog">
            <?php $form = ActiveForm::begin([
                'id' => 'item-form',
                'options' => ['class' => 'layui-form layui-text'],
                'fieldConfig' => [
                    'options' => ['class' => 'layui-form-item'],
                    'labelOptions' => ['class' => 'layui-form-label','align'=>'right','style'=>'width:100px'],
                    'template' => '{label}<div class="layui-input-inline" style="width: 30%">{input}</div>{hint}{error}',
                ],
            ]); ?>

            <?= $form->field($model, 'p_id')->dropDownList(\yii\helpers\ArrayHelper::map($channelDropdown,'id','name'))->label('默认入库栏目') ?>
            <?= $form->field($model,'seconds')->textInput(['type'=>'number','class'=>'layui-input'])->hint('单位：（秒）为减轻服务器压力，每循环10条数据暂停N秒 例：3 代表“3秒”')?>

            <div class='layui-form-item'>
                <div class="layui-form-label" style="width: 100px;"></div>
                <div class="layui-input-block" style="margin-left: 120px;">
                    <?= Html::button('<i class="layui-icon layui-icon-refresh-3 layui-anim"></i>开始入库', ['class' => 'layui-btn','id'=>'push']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


<?php
$push_url = \yii\helpers\Url::toRoute(['storage','c_id'=>$c_id]);
$js =<<<JS
layui.config({
	base : "js/"
}).use(['form','layer','jquery'],function(){
	var form = layui.form,
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		$ = layui.jquery
        ,table = layui.table;

    //入库
    $('body').on('click','#push',function() {
        var _this = this;
        $(_this).addClass('layui-btn-disabled').find('i').addClass('layui-anim-rotate layui-anim-loop');
        var params = {p_id:$('#content-p_id').val(),seconds:$('#content-seconds').val()};
        $.post('$push_url',{Content:params},function(data){
            layer.msg(data.message);
            $(_this).removeClass('layui-btn-disabled').find('i').removeClass('layui-anim-rotate layui-anim-loop');
        },"json").fail(function(a,b,c){
            if(a.status==403){
                layer.msg('没有权限');
            }else{
                layer.msg('系统错误');
            }
            $(_this).removeClass('layui-btn-disabled').find('i').removeClass('layui-anim-rotate layui-anim-loop');
        });
    })
});
JS;
$this->registerJs($js);

?>