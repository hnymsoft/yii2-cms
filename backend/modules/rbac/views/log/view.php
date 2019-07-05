<?php
use yii\widgets\DetailView;
use backend\assets\LayuiAsset;

LayuiAsset::register($this);
$this->params['breadcrumbs'][] = ['label' => '权限管理','url'=>\yii\helpers\Url::toRoute(['user/index'])];
$this->params['breadcrumbs'][] = ['label' => '日志列表','url'=>\yii\helpers\Url::toRoute(['log/index'])];
$this->params['breadcrumbs'][] = '详情';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">日志详情</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?=DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'route',
                    'url',
                    'user_agent',
                    'gets:ntext',
                    'posts:ntext',
                    'admin_email',
                    'updated_at',
                    'created_at',
                ],
                'options' => ['class' => 'layui-table','lay-skin' => 'line'],
                'template' => '<tr><th width="90px;">{label}</th><td>{value}</td></tr>',
            ]);
            ?>
        </div>
    </div>
</div>
