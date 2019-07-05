<?php

use yii\helpers\Html;
use yii\grid\GridView;
$this->params['breadcrumbs'][] = ['label' => '扩展管理','url'=>\yii\helpers\Url::toRoute(['flink/index'])];
$this->registerJs($this->render('js/_script.js'));
$this->params['breadcrumbs'][] = '留言列表';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">留言列表</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?php echo $this->render('_search',['model' => $searchModel]); ?>

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
                    [
                        'attribute' => 'id',
                        'headerOptions' => [
                            'width' => '5%',
                            'style'=> 'text-align: center;'
                        ],
                        'contentOptions' => ['align'=>'center'],
                    ],
                    'subject',
                    'content',
                    'name',
                    'mobile',
                    'addtime',
                    [
                        'label' => '是否前台显示',
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
                                'lay-text' => '是|否',
                                'data-url' => \yii\helpers\Url::toRoute(['ajaxstatus','id' => $model->id])
                            ]);
                        }
                    ],
                    [
                        'header' => '操作',
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['align'=>'center'],
                        'headerOptions' => [
                            'width' => '12%',
                            'style'=> 'text-align: center;'
                        ],
                        'template' =>'{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url){
                                return Html::a('查看', $url, ['class' => "layui-btn layui-btn-xs layui-default-view"]);
                            },
                            'update' => function ($url) {
                                return Html::a('回复', $url, ['class' => "layui-btn layui-btn-normal layui-btn-xs layui-default-update"]);
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
