<?php
use yii\helpers\Html;
use yii\grid\GridView;

$columns = [
    [
		'class' => 'yii\grid\SerialColumn',
		'contentOptions' => ['style'=> 'text-align: center;'],
		'headerOptions' => [
			'width' => '5%',
			'style'=> 'text-align: center;'
		]
	],
    $usernameField,
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] =[
        'header' => '操作',
        'class' => 'yii\grid\ActionColumn',
        'contentOptions' => ['class'=>'text-center'],
        'headerOptions' => [
            'width' => '5%',
            'style'=> 'text-align: center;'
        ],
        'template' =>'{view}',
        'buttons' => [
            'view' => function ($url){
                return Html::a('授权', $url, ['class' => "layui-btn layui-btn-xs layui-default-view"]);
            },
        ]
    ];
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>

        <div class="layui-card-body">
            <?=GridView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'grid-view','style'=>'overflow:auto', 'id' => 'grid-view'],
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
                'columns' => $columns,
            ]);
            ?>
        </div>
    </div>
</div>
