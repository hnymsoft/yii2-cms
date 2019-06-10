<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <?php  echo $this->render('_search',['model' => $searchModel]); ?>
        </div>
        <div class="layui-card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
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
                    [
                        'label' => 'typeid',
                        'value' => function($model){
                            return $model->flinktype->typename;
                        }
                    ],
                    'webname',
                    'linkurl',
                    [
                        'label' => '网站Logo',
                        'headerOptions' => [
                            'width' => '12%',
                            'style'=> 'text-align: center;'
                        ],
                        'contentOptions' => ['align'=>'center'],
                        'format' => 'raw',
                        'value' => function($model){
                            return isset($model->logo) ? '<img src="'.$model->logo.'" width="200" height="40" />' : '--';
                        }
                    ],
                    [
                        'label' => '网站介绍',
                        'headerOptions' => [
                            'width' => '25%',
                            'style'=> 'text-align: center;'
                        ],
                        'value' => function($model){
                            return $model->introduce;
                        }
                    ],
                    [
                        'label' => '显示顺序',
                        'headerOptions' => [
                            'width' => '8%',
                            'style'=> 'text-align: center;'
                        ],
                        'contentOptions' => ['align'=>'center'],
                        'value' => function($model){
                            return $model->order;
                        }
                    ],
                    [
                        'label' => '链接状态',
                        'headerOptions' => [
                            'width' => '8%',
                            'style'=> 'text-align: center;'
                        ],
                        'contentOptions' => ['align'=>'center'],
                        'value' => function($model){
                            return $model->status == 1 ? '通过' : '待审';
                        }
                    ],
                    [
                        'header' => '操作',
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['align'=>'center'],
                        'headerOptions' => [
                            'width' => '8%',
                            'style'=> 'text-align: center;'
                        ],
                        'template' =>'{view} {update} {delete}',
                        'buttons' => [
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
    </div>
</div>
