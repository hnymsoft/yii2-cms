<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" id="main-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this">模型字段列表</li>
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
                                    'attribute' => 'name',
                                    'headerOptions' => [
                                        'width' => '15%',
                                    ],
                                    'value' => function($model){
                                        return $model->name;
                                    }
                                ],
                                [
                                    'attribute' => 'item',
                                    'headerOptions' => [
                                        'width' => '15%',
                                        'style'=> 'text-align: center;'
                                    ],
                                    'contentOptions' => ['align'=>'center'],
                                    'value' => function($model){
                                        return $model->item;
                                    }
                                ],
                                [
                                    'attribute' => 'm_id',
                                    'headerOptions' => [
                                        'width' => '15%',
                                        'style'=> 'text-align: center;'
                                    ],
                                    'contentOptions' => ['align'=>'center'],
                                    'value' => function($model){
                                        return $model->modules->name;
                                    }
                                ],
                                [
                                    'attribute' => 'f_type',
                                    'headerOptions' => [
                                        'width' => '15%',
                                        'style'=> 'text-align: center;'
                                    ],
                                    'contentOptions' => ['align'=>'center'],
                                    'value' => function($model){
                                        return \common\models\ExtField::$input_type[$model->f_type];
                                    }
                                ],
                                'desc',
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
    </div>
</div>
