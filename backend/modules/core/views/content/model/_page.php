<?php foreach($extend_filed AS $key => $val):?>
    <?php if (in_array($val['f_type'],[4,5])):?>
        //数字文本框
    <?php elseif ($val['f_type'] == 3):?>
        //文本域
    <?php elseif ($val['f_type'] == 6):?>
        //时间选择
    <?php elseif ($val['f_type'] == 7):?>
        //下拉
    <?php elseif ($val['f_type'] == 8):?>
        //单选
    <?php elseif ($val['f_type'] == 9):?>
        //复选
    <?php else:?>
        //文本框
    <?php endif;?>
<?php endforeach;?>
