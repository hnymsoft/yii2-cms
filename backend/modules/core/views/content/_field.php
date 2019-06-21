<?php foreach($extend_filed AS $key => $val):?>
    <?php if (in_array($val['f_type'],[4,5])):?>
        <?= $form->field($attachTableModel, $val['item'])->textInput(['type'=>'number','class'=>'layui-input'])->label($val['name']) ?>
    <?php elseif ($val['f_type'] == 3):?>
        <?= $form->field($attachTableModel, $val['item'])->textarea(['row'=>'6','class'=>'layui-textarea'])->label($val['name']) ?>
    <?php elseif ($val['f_type'] == 6):?>
        <?= $form->field($attachTableModel, $val['item'],[
            'template' => '{label}<div class="layui-input-inline cal" style="width: 35%">{input}<i class="cus fa fa-calendar"></i></div><span class="help-block">{error}</span>',
        ])->textInput(['class'=>'layui-input','id'=>'ext_'.$val['item']])->label($val['name']) ?>
<?php
$js = <<<JS
layui.use(['form','jquery','laydate'],function(){
        var form = layui.form
        ,$ = layui.jquery
        ,laydate = layui.laydate;
        
        laydate.render({
            elem: '#ext_{$val['item']}'
            ,type: 'datetime'
        });
    });
JS;
$this->registerJs($js,\yii\web\View::POS_END);
?>
    <?php elseif ($val['f_type'] == 7):?>
        <?= $form->field($attachTableModel, $val['item'])->dropDownList(explode(',',$val['value']))->label($val['name']) ?>
    <?php elseif ($val['f_type'] == 8):?>
        <?= $form->field($attachTableModel, $val['item'])->radioList(explode(',',$val['value']),['item'=>function($index, $label, $name, $checked, $value){
            return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' title="'.$label.'">';
        }])->label($val['name']) ?>
    <?php elseif ($val['f_type'] == 9):?>
        <?= $form->field($attachTableModel, $val['item'])->checkboxList(explode(',',$val['value']),['item'=>function($index, $label, $name, $checked, $value){
            return '<input type="checkbox" name="'.$name.'" value="'.$value.'" '.($checked?"checked":"").' lay-skin="primary" title="'.$label.'">';
        }])->label($val['name']) ?>
    <?php else:?>
        <?= $form->field($attachTableModel, $val['item'])->textInput(['maxlength' => true,'class'=>'layui-input'])->label($val['name']) ?>
    <?php endif;?>
<?php endforeach;?>
