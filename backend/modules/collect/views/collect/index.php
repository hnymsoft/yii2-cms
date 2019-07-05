<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->registerJs($this->render('js/_script.js'));
$this->params['breadcrumbs'][] = ['label' => '采集管理','url'=>\yii\helpers\Url::toRoute(['collect/index'])];
$this->params['breadcrumbs'][] = '采集规则列表';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">采集规则列表</li>
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
                    [
                        'attribute' => 'encoding',
                        'value' => function($model){
                            switch ($model->encoding){
                                case 0:
                                    $encode = 'UTF-8';
                                    break;
                                case 1:
                                    $encode = 'GB2312';
                                    break;
                                case 2:
                                    $encode = 'BIG-5';
                                    break;
                                default:
                                    $encode = '未知';
                                    break;
                            }
                            return $encode;
                        }
                    ],
                    'num',
                    'create_addtime',
                    'update_addtime',
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
                            'width' => '19%',
                            'style'=> 'text-align: center;'
                        ],
                        'template' =>'{view} {update} {delete} {test} {initcollect} {storage}',
                        'buttons' => [
                            'view' => function ($url, $model, $key){
                                return Html::a('查看', \yii\helpers\Url::toRoute(['collecthtml/index','c_id'=>$model->id]), ['class' => "layui-btn layui-btn-primary layui-btn-xs layui-default-view"]);
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
                            'initcollect' => function ($url) {
                                return Html::a('采集', $url, ['class' => "layui-btn layui-btn-warm layui-btn-xs layui-default-collect"]);
                            },
                            'storage' => function ($url, $model, $key) {
                                return Html::a('入库', \yii\helpers\Url::toRoute(['collecthtml/pushindex','c_id'=>$model->id]), ['class' => "layui-btn layui-btn-xs layui-default-collect"]);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
