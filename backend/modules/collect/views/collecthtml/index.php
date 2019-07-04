<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" id="main-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this">临时内容管理</li>
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
                                [
                                    'headerOptions' => [
                                        'width' => '10%',
                                        'style'=> 'text-align: center;'
                                    ],
                                    'contentOptions' => ['align'=>'center'],
                                    'attribute' => 'c_id',
                                    'value' => function($model){
                                        return $model->collect->name;
                                    }
                                ],
                                'title',
                                'url:url',
                                'create_addtime',
                                [
                                    'headerOptions' => [
                                        'width' => '6%',
                                        'style'=> 'text-align: center;'
                                    ],
                                    'contentOptions' => ['align'=>'center'],
                                    'attribute' => 'is_down',
                                    'value' => function($model){
                                        return $model->is_down == 1 ? '已下载' : '未下载';
                                    }
                                ],
                                [
                                    'headerOptions' => [
                                        'width' => '6%',
                                        'style'=> 'text-align: center;'
                                    ],
                                    'contentOptions' => ['align'=>'center'],
                                    'attribute' => 'is_export',
                                    'value' => function($model){
                                        return $model->is_export == 1 ? '已导出' : '未导出';
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
                                    'template' =>'{update} {delete}',
                                    'buttons' => [
                                        'update' => function ($url) {
                                            return Html::a('编辑', $url, ['class' => "layui-btn layui-btn-normal layui-btn-xs layui-default-update"]);
                                        },
                                        'delete' => function ($url) {
                                            return Html::a('删除', $url, ['class' => "layui-btn layui-btn-danger layui-btn-xs layui-default-delete"]);
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
