<?php
use yii\helpers\Html;
use backend\assets\LayuiAsset;

$path = \Yii::$app->controller->module->id.'/'.\Yii::$app->controller->id.'/'.\Yii::$app->controller->action->id;

$action_list = [
    'cache/index',
    'index/welcome'
];

LayuiAsset::addScript($this, "@web/static/js/common.js");
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
<body class="box-body">

<?php $this->beginBody() ?>
    <?php if (in_array(Yii::$app->controller->id . '/' . Yii::$app->controller->action->id, $action_list)):?>
        <?= $content ?>
    <?php else:?>
        <div class="layui-fluid">
            <div class="layui-card">
                <div class="layui-card-body">
                    <!--面包屑导航 开始-->
                    <?= \yii\widgets\Breadcrumbs::widget([
                        'tag'=>'span',
                        'options' => ['class'=>'layui-breadcrumb'],
                        'itemTemplate' => '{link}',
                        'activeItemTemplate' => '<a><cite>{link}</cite></a>',
                        'homeLink' => ['label' => '主页','url' => \yii\helpers\Url::toRoute(['/system/index/welcome'])],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs']:[]
                    ]) ?>
                    <!--面包屑导航 结束-->
                    <?= $content ?>
                </div>
            </div>
        </div>
    <?php endif;?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>



