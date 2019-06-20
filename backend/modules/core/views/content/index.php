<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <?php  echo $this->render('_search',['model' => $searchModel,'channelDropdown' => $channelDropdown]); ?>
        </div>
        <div class="layui-card-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'options' => ['class' => 'grid-view layui-form','style'=>'overflow:auto', 'id' => 'grid-view'],
        'layout' => "{items}\n{pager}",
        'tableOptions'=> ['class'=>'layui-table'],
        'pager' => [
            'options'=>['class'=>'layuipage pull-right'],
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页',
            'maxButtonCount'=>5,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'p_id',
            'm_id',
            'color',
            'title',
            //'keywords',
            //'description',
            //'thumb',
            //'money',
            //'flag',
            //'auther',
            //'click',
            //'source',
            //'status',
            //'create_addtime:datetime',
            //'update_addtime:datetime',
            //'create_user',
            //'update_user',

            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['align'=>'center'],
                'headerOptions' => [
                    'width' => '10%',
                    'style'=> 'text-align: center;'
                ],
                'template' =>'{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('查看', $url, ['class' => "layui-btn layui-btn-xs layui-default-view"]);
                    },
                    'update' => function ($url) {
                        return Html::a('修改', $url, ['class' => "layui-btn layui-btn-normal layui-btn-xs layui-default-update"]);
                    },
                    'delete' => function ($url) {
                        return Html::a('删除', $url, ['class' => "layui-btn layui-btn-danger layui-btn-xs layui-default-delete"]);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
