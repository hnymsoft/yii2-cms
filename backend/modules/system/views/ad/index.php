<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" id="main-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this">广告列表</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <?php echo $this->render('_search',['model' => $searchModel]); ?>

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
                                'id',
                                [
                                    'label' => '广告位置',
                                    'value' => function($model){
                                        return $model->adPosition->position_name;
                                    }
                                ],
                                'ad_name',
                                [
                                    'attribute' => 'media_type',
                                    'value' => function($model){
                                        if($model->media_type == 0){
                                            return '图片';
                                        }elseif ($model->media_type == 1){
                                            return '文字';
                                        }elseif ($model->media_type == 2){
                                            return '代码';
                                        }else{
                                            return '未知';
                                        }
                                    }
                                ],
                                'start_time',
                                'end_time',
                                [
                                    'attribute' => 'click_count',
                                    'headerOptions' => ['style'=> 'text-align: center;'],
                                    'contentOptions' => ['align'=>'center'],
                                ],
                                [
                                    'attribute' => 'status',
                                    'headerOptions' => ['style'=> 'text-align: center;'],
                                    'contentOptions' => ['align'=>'center'],
                                    'value' => function($model){
                                        if($model->status == 1){
                                            return '开启';
                                        }else{
                                            return '关闭';
                                        }
                                    }
                                ],
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
                                        'view' => function ($url){
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
                </div>
            </div>
        </div>
    </div>
</div>
