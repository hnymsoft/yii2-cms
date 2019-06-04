<?php
use yii\helpers\Html;
$this->title = $name;
?>

<div class="system-message">
    <h1>:(</h1>
    <p class="error"><?= Html::encode($this->title) ?></p>
    <p class="detail"><?= nl2br(Html::encode($message)) ?></p>
    <p class="jump">
        页面自动 <a id="href" href="<?=Yii::$app->request->referrer?>">跳转</a> 等待时间： <b id="wait">10</b>
    </p>
</div>

<?php
$css =<<<CSS
*{ padding: 0; margin: 0; }
body{ background: #fff; font-family: "Microsoft Yahei","Helvetica Neue",Helvetica,Arial,sans-serif; color: #333; font-size: 16px; }
.system-message{ padding: 25px 50px 50px; }
.system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
.system-message .jump{ padding-top: 10px; }
.system-message .jump a{ color: #333; }
.system-message .jump b{color: red;}
.system-message .error{ line-height: 1.8em; font-size: 36px; }
.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display: none; }
CSS;
$this->registerCss($css);

$js = <<<JS
    var wait = document.getElementById('wait'),
    href = document.getElementById('href').href;
    var interval = setInterval(function(){
        var time = --wait.innerHTML;
        if(time <= 0) {
            location.href = href;
            clearInterval(interval);
        };
    }, 1000);
JS;
$this->registerJs($js);
?>