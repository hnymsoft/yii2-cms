<?php

use yii\helpers\Html;
use yii\grid\GridView;
$this->registerJs($this->render('js/_script.js'));
$this->params['breadcrumbs'][] = '轮播图列表';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">轮播图列表</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?php echo $this->render('_search',['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'options' => ['class' => 'grid-view layui-form','style'=>'overflow:auto', 'id' => 'grid-view'],
                'layout' => "{items}\n{pager}",
                'tableOptions'=> ['class'=>'layui-table','lay-filter'=>'order'],
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
                        'attribute' => 'pic',
                        'format' => 'raw',
                        'headerOptions' => [
                            'width' => '6%',
                            'style'=> 'text-align: center;'
                        ],
                        'contentOptions' => ['align'=>'center'],
                        'value' => function($model){
                            return Html::img($model->pic,['style'=>'width:100%;height:30px;border:1px dashed #ededed;']);
                        }
                    ],
                    [
                        'attribute' => 'link',
                        'headerOptions' => [
                            'width' => '15%',
                        ],
                        'value' => function($model){
                            return $model->link;
                        }
                    ],
                    [
                        'attribute' => 'title',
                        'headerOptions' => [
                            'width' => '15%',
                        ],
                        'value' => function($model){
                            return $model->title;
                        }
                    ],
                    [
                        'attribute' => 'subtitle',
                        'headerOptions' => [
                            'width' => '15%',
                        ],
                        'value' => function($model){
                            return $model->subtitle;
                        }
                    ],
                    [
                        'attribute' => 'order',
                        'format' => 'raw',
                        'headerOptions' => [
                            'width' => '5%',
                            'style'=> 'text-align: center;'
                        ],
                        'contentOptions' => ['align'=>'center'],
                        'value' => function($model){
                            return $model->id;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'headerOptions' => [
                            'width' => '6%',
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
                            'width' => '6%',
                            'style'=> 'text-align: center;'
                        ],
                        'template' =>'{update} {delete}',
                        'buttons' => [
                            'update' => function ($url) {
                                return Html::a('编辑', $url, ['class' => "layui-btn layui-btn-normal layui-btn-xs layui-default-update"]);
                            },
                            'delete' => function ($url,$model) {
                                return Html::a('删除', $url, ['class' => "layui-btn layui-btn-danger layui-btn-xs layui-default-delete"]);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
