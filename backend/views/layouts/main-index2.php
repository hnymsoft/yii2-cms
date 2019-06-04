<?php
use yii\helpers\Html;
use backend\assets\LayuiAsset;

LayuiAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="login-bg">
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>



