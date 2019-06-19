<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->registerJs($this->render('js/_script.js'));
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <?php  echo $this->render('_search',['model' => $searchModel]); ?>
        </div>
        <div class="layui-card-body">
            <table id="channel" class="layui-table layui-form" lay-filter="channel"></table>
        </div>
    </div>
</div>

