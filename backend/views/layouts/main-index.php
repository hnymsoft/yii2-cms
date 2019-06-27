<?php
use rbac\components\MenuHelper;
use backend\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\LayuiAsset;
$this->title = '管理系统';
$menu = Menu::widget([
    'options' => ['class' => 'layui-nav layui-nav-tree'],
    'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id, null, function($menu){
        $items = $menu['children'];
        $return = [
            'label' => $menu['name'],
            'url' => [$menu['route']],
        ];
        if(isset($menu['icon'])){
            $return['icon'] = $menu['icon'];
        }else{
            $return['icon'] = 'icon fa fa-circle-o';
        }
        $items && $return['items'] = $items;
        return $return;
    }),
]);
LayuiAsset::addScript($this, "@web/static/js/main.js");
LayuiAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="layui-layout-body">
<?php $this->beginBody() ?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">后台管理系统</div>
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="javascript:;" id="hideMenu"><i class="fa fa-dedent"></i></a></li>
            <li class="layui-nav-item"><a href="javascript:;" class="changeSkin"><i class="iconfont icon-yifu userMenu"></i><cite>换肤</cite></a></li>
            <li class="layui-nav-item lockcms"><a href="javascript:;"><i class="iconfont icon-lock"></i><cite>锁屏</cite></a></li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item"><a href="/"><i class="fa fa-home"></i><cite>网站主页</cite></a></li>
            <li class="layui-nav-item panel">
                <a href="javascript:;" data-url="<?=Url::toRoute(['system/cache/index'])?>"><i class="fa fa-trash-o"></i><cite>清理缓存</cite></a>
            </li>
            <li class="layui-nav-item panel">
                <a href="javascript:;">
                    <?=Html::img(Yii::$app->user->identity->head_pic,['id'=>'avatar','style'=>'display:none'])?>
                    <cite id="username"><?=Yii::$app->user->identity->nickname?></cite>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" data-url="<?= Url::to(['rbac/user/update-self','id'=>Yii::$app->user->identity->id])?>"><i class="iconfont icon-wo userMenu"></i><cite>个人中心</cite></a></dd>
                    <dd><a href="<?= Url::to(['rbac/user/logout'])?>" class="signOut"><i class="iconfont icon-logout userMenu"></i><cite>退出</cite></a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll navBar">
            <?=$menu?>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div class="layui-tab marg0" lay-filter="tab" id="top_tabs_box">
            <ul class="layui-tab-title top_tab" id="top_tabs">
                <li class="layui-this" lay-id=""><i class="iconfont">&#xe603;</i> <cite>后台首页</cite></li>
            </ul>
            <ul class="layui-nav opt">
                <li class="layui-nav-item">
                    <a href="javascript:;" class="refresh refreshThis" title="刷新当前"><i class="iconfont icon-refresh"></i></a>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;" class="closePageOther" title="关闭其他"><i class="iconfont icon-guanbi"></i></a>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;" class="closePageAll" title="关闭全部"><i class="iconfont icon-close"></i></a>
                </li>
            </ul>
            <div class="layui-tab-content clildFrame">
                <div class="layui-tab-item layui-show">
                    <iframe src="<?=Url::toRoute(['system/index/welcome'])?>" data-id="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="layui-footer" align="center">
        <!-- 底部固定区域 -->
        © aimitech.com - xiaoai
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>