<?php
$this->params['breadcrumbs'][] = ['label' => '留言列表','url'=>\yii\helpers\Url::toRoute(['guestbook/index'])];
$this->params['breadcrumbs'][] = '回复';
?>
<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">留言回复</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>