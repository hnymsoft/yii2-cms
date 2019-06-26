<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->registerJs($this->render('js/_script.js'));
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" id="main-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this">栏目列表</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <?php echo $this->render('_search',['model' => $searchModel]); ?>

                        <table id="channel" class="layui-table layui-form" lay-filter="channel"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

