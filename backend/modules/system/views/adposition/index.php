<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->params['breadcrumbs'][] = ['label' => '扩展管理','url'=>\yii\helpers\Url::toRoute(['flink/index'])];
$this->params['breadcrumbs'][] = '广告位列表';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">广告位列表</li>
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
                    'position_name',
                    [
                        'label' => '规格(px)',
                        'value' => function($model){
                            return $model->ad_width.' x '.$model->ad_height;
                        }
                    ],
                    'position_desc',
                    [
                        'attribute' => 'position_style',
                        'headerOptions' => ['width'=>'27%'],
                        'contentOptions' => ['align'=>'center'],
                        'value' => function($model){
                            return !empty($model->position_style) ? $model->position_style : '未生成（添加广告启用后生成）';
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
                            'view' => function ($url,$model){
                                return Html::a('查看广告', \yii\helpers\Url::to(['ad/index','Ad[position_id]'=>$model->id]), ['class' => "layui-btn layui-btn-xs layui-default-view"]);
                            },
                            'update' => function ($url) {
                                return Html::a('编辑', $url, ['class' => "layui-btn layui-btn-normal layui-btn-xs layui-default-update"]);
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

