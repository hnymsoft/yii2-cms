<?php
    //多版本富文本编辑器
    $conf = \common\models\Setting::getConfInfo('cfg_editor');
    if($conf){
        if($conf->value == 'UEditor'){
?>
            <?php $this->registerJsFile('@web/static/ueditor1_4_3_3/ueditor.config.js',['position'=>\yii\web\View::POS_HEAD]) ?>
            <?php $this->registerJsFile('@web/static/ueditor1_4_3_3/ueditor.all.min.js',['position'=>\yii\web\View::POS_HEAD]) ?>
            <?php $this->registerJsFile('@web/static/ueditor1_4_3_3/lang/zh-cn/zh-cn.js',['position'=>\yii\web\View::POS_HEAD]) ?>
            <?php $this->registerJs("UE.getEditor('editor');",\yii\web\View::POS_HEAD) ?>
<?php
        }elseif($conf->value == 'CKeditor'){
?>
            <?php $this->registerJsFile('@web/static/ckeditor/ckeditor.js',['position'=>\yii\web\View::POS_HEAD]) ?>
            <?php $this->registerJsFile('@web/static/ckeditor/config.js',['position'=>\yii\web\View::POS_HEAD]) ?>
            <?php $this->registerJs("CKEDITOR.replace( 'editor' );",\yii\web\View::POS_END) ?>
<?php
        }else{
            echo '<p style="line-height: 38px;color:red;">编辑器不存在，请检查系统配置~</p>';
        }
    }else{
        echo '<p style="line-height: 38px;color:red;">编辑器不存在，请在系统设置中配置~</p>';
    }
?>
