<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->params['breadcrumbs'][] = ['label' => '系统管理','url'=>\yii\helpers\Url::toRoute(['setting/index'])];
$this->registerJs($this->render('js/_script.js'));
$this->params['breadcrumbs'][] = '模型列表';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">模型列表</li>
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
                    'name',
                    'attach_table',
                    'list_tpl',
                    'content_tpl',
                    [
                        'attribute' => 'is_system',
                        'contentOptions' => ['align'=>'center'],
                        'headerOptions' => [
                            'width' => '8%',
                            'style'=> 'text-align: center;'
                        ],
                        'format' => 'raw',
                        'value' => function($model){
                            return $model->is_system == 1 ? '<font color="red">是</font>' : '<font color="green">否</font>';
                        }
                    ],
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
                            'width' => '12%',
                            'style'=> 'text-align: center;'
                        ],
                        'template' =>'{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url){
                                return Html::a('查看', $url, ['class' => "layui-btn layui-btn-xs layui-default-view"]);
                            },
                            'update' => function ($url) {
                                return Html::a('编辑', $url, ['class' => "layui-btn layui-btn-normal layui-btn-xs layui-default-update"]);
                            },
                            'delete' => function ($url,$model) {
                                if($model->is_system != 1){
                                    return Html::a('删除', $url, ['class' => "layui-btn layui-btn-danger layui-btn-xs layui-default-delete"]);
                                }
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

