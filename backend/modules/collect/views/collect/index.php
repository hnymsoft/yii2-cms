<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\Collect */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Collects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" id="main-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this">采集节点列表</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <?php echo $this->render('_search',['model' => $searchModel]); ?>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'options' => ['class' => 'grid-view','style'=>'overflow:auto', 'id' => 'grid-view'],
                            'layout' => "{items}\n{pager}",
                            'tableOptions'=> ['class'=>'layui-table layui-form'],
                            'pager' => [
                                'options'=>['class'=>'layuipage pull-right'],
                                'prevPageLabel' => '上一页',
                                'nextPageLabel' => '下一页',
                                'firstPageLabel'=>'首页',
                                'lastPageLabel'=>'尾页',
                                'maxButtonCount'=>5,
                            ],
                            'columns' => [
                                [
                                    'label' => 'ID',
                                    'headerOptions' => [
                                        'width' => '4%',
                                        'style'=> 'text-align: center;'
                                    ],
                                    'contentOptions' => ['align'=>'center'],
                                    'format' => 'raw',
                                    'value' => function($model){
                                        return $model->id;
                                    }
                                ],
                                'name',
                                'encoding',
                                'num',
                                'create_addtime',
                                [
                                    'attribute' => 'status',
                                    'headerOptions' => [
                                        'width' => '8%',
                                        'style'=> 'text-align: center;'
                                    ],
                                    'contentOptions' => ['align'=>'center'],
                                    'format' => 'raw',
                                    'value' => function($model){
                                        $status = $model->status == 1 ? true : false;
                                        return Html::checkbox('status',$status,[
                                            'lay-skin' => 'switch',
                                            'lay-filter' => 'status',
                                            'lay-text' => '启用|禁用',
                                            'data-url' => \yii\helpers\Url::toRoute(['ajaxstatus','id' => $model->id])
                                        ]);
                                    }
                                ],
                                [
                                    'header' => '操作',
                                    'class' => 'yii\grid\ActionColumn',
                                    'contentOptions' => ['align'=>'center'],
                                    'headerOptions' => [
                                        'width' => '17%',
                                        'style'=> 'text-align: center;'
                                    ],
                                    'template' =>'{view} {update} {delete} {test} {start}',
                                    'buttons' => [
                                        'view' => function ($url){
                                            return Html::a('查看', $url, ['class' => "layui-btn layui-btn-xs layui-default-view"]);
                                        },
                                        'update' => function ($url) {
                                            return Html::a('编辑', $url, ['class' => "layui-btn layui-btn-normal layui-btn-xs layui-default-update"]);
                                        },
                                        'delete' => function ($url) {
                                            return Html::a('删除', $url, ['class' => "layui-btn layui-btn-danger layui-btn-xs layui-default-delete"]);
                                        },
                                        'test' => function ($url) {
                                            return Html::a('测试', $url, ['class' => "layui-btn layui-btn-primary layui-btn-xs layui-default-test"]);
                                        },
                                        'start' => function ($url) {
                                            return Html::a('采集', $url, ['class' => "layui-btn layui-btn-warm layui-btn-xs layui-default-collect"]);
                                        },
                                    ]
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>