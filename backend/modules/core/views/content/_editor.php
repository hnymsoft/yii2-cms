<?php
    //多版本富文本编辑器
    $conf = \common\models\Setting::getConfInfo('cfg_editor');
    if($conf){
        if($conf->value == 'UEditor'){
?>
    <div type="text/plain" id="editor" name="AttachTable[body]"></div>
    <?php $this->registerJsFile('@web/plugins/editor/ueditor1_4_3_3/ueditor.config.js',['position'=>\yii\web\View::POS_HEAD]) ?>
    <?php $this->registerJsFile('@web/plugins/editor/ueditor1_4_3_3/ueditor.all.min.js',['position'=>\yii\web\View::POS_HEAD]) ?>
    <?php $this->registerJsFile('@web/plugins/editor/ueditor1_4_3_3/lang/zh-cn/zh-cn.js',['position'=>\yii\web\View::POS_HEAD]) ?>

<?php
$content = trim($attachTableModel->body);
$js = <<<JS
var editor = UE.getEditor("editor");
    editor.ready(function(){
        editor.setContent('{$content}');
    })
JS;
$this->registerJs($js,\yii\web\View::POS_END);
?>
<?php
        }elseif($conf->value == 'CKeditor'){
?>
            <textarea id="editor" name="AttachTable[body]"><?=$attachTableModel->body?></textarea>
            <?php $this->registerJsFile('@web/plugins/editor/ckeditor/ckeditor.js',['position'=>\yii\web\View::POS_HEAD]) ?>
            <?php $this->registerJsFile('@web/plugins/editor/ckeditor/config.js',['position'=>\yii\web\View::POS_HEAD]) ?>
<?php
$js2 = <<<JS
var editor = CKEDITOR.replace('editor',{ allowedContent: true });    
    CKEDITOR.on( 'instanceReady', function(evt) {
        var editor = evt.editor,
            body = CKEDITOR.document.getBody();
        
        //获取焦点
        editor.on( 'focus', function(){});
        
        //失去焦点
        editor.on( 'blur', function(){
            $('#body').text(editor.getData());
        });    
    });    
    
JS;
$this->registerJs($js2,\yii\web\View::POS_END);
?>

<?php
        }else{
            echo '<p style="line-height: 38px;color:red;">编辑器不存在，请检查系统配置~</p>';
        }
    }else{
        echo '<p style="line-height: 38px;color:red;">编辑器不存在，请在系统设置中配置~</p>';
    }
?>
