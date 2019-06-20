<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <a href="<?=Yii::$app->request->referrer?>" class="layui-btn layui-btn-primary layui-btn-sm">返回上一页</a>
        </div>
        <div class="layui-card-body">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'layui-table','style'=>'margin-top:0'],
                'template' => '<tr><th width="90px;">{label}</th><td>{value}</td></tr>',
                'attributes' => [
                    'id',
                    'p_id',
                    'm_id',
                    'color',
                    'title',
                    'keywords',
                    'description',
                    'thumb',
                    'money',
                    'flag',
                    'author',
                    'click',
                    'source',
                    'status',
                    'create_addtime',
                    'update_addtime',
                    'create_user',
                    'update_user',
                ],
            ]) ?>
        </div>
    </div>
</div>
</div>