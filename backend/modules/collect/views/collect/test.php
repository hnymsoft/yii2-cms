<?php
$this->params['breadcrumbs'][] = ['label' => '采集管理','url'=>\yii\helpers\Url::toRoute(['collect/index'])];
$this->params['breadcrumbs'][] = ['label' => '采集规则列表','url'=>\yii\helpers\Url::toRoute(['collect/index'])];
$this->params['breadcrumbs'][] = '采集测试';
?>
<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this"><?=$subject?> - 采集测试（本次共采集（<?=count($data)?>）条数据）</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <pre><?php print_r($data)?></pre>
        </div>
    </div>
</div>