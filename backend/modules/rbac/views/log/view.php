<?php
use yii\widgets\DetailView;
use backend\assets\LayuiAsset;

LayuiAsset::register($this);
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <a href="" class="layui-btn layui-btn-primary layui-btn-sm" id="prev">返回上一页</a>
        </div>
        <div class="layui-card-body">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>日志记录 详情</legend>
            </fieldset>

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