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

$this->params['breadcrumbs'][] = ['label' => '权限管理','url'=>\yii\helpers\Url::toRoute(['user/index'])];
$this->params['breadcrumbs'][] = '角色分配列表';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">角色分配列表</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

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
