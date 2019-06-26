<?php
use yii\widgets\DetailView;
use backend\assets\LayuiAsset;

LayuiAsset::register($this);
?>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
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
        </div>
    </div>
</div>