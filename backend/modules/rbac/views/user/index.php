<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->registerJs($this->render('js/index.js'));
?>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="layui-card-body">
            <?=GridView::widget([
                'dataProvider' => $dataProvider,
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
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style'=> 'text-align: center;'],
                        'headerOptions' => [
                            'width' => '50px',
                            'style'=> 'text-align: center;'
                        ],
                    ],
                    [
                        'attribute' => 'nickname',
                        'headerOptions' => ['width'=>'100','style'=> 'text-align: center;'],
                        'contentOptions' => ['style'=> 'text-align: center;']
                    ],
                    [
                        'attribute' => 'head_pic',
                        'contentOptions' => ['style'=> 'text-align: center;'],
                        'headerOptions' => ['width'=>'110','style'=> 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function($model){
                            if($model->head_pic){
                                $conf = \common\models\Setting::getConfInfo('cfg_domain');
                                $url = preg_match("/^http(s)?:\\/\\/.+/",$model->head_pic) ? $model->head_pic : $conf->value .'/'. $model->head_pic;
                                return Html::img($url,['class'=>'layui-circle','width'=>'45px','height'=>'45px']);
                            }else{
                                return '--';
                            }
                        }
                    ],
                    [
                        'attribute' => 'username',
                        'contentOptions' => ['style'=> 'text-align: center;'],
                        'headerOptions' => [
                            'width' => '10%',
                            'style'=> 'text-align: center;'
                        ],
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'email',
                        'contentOptions' => ['style'=> 'text-align: center;'],
                        'headerOptions' => [
                            'width' => '10%',
                            'style'=> 'text-align: center;'
                        ],
                    ],
                    [
                        'attribute' => 'created_at',
                        'contentOptions' => ['class'=>'text-center'],
                        'value' => function($model){
                            return date("Y-m-d H:i:s",$model->created_at);
                        },
                        'headerOptions' => [
                            'style'=> 'text-align: center;'
                        ],
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'html',
                        'value' => function($model) {
                            return $model->status==0?'<font color="red">禁用</font>':'<font color="green">启用</font>';
                        },
                        'contentOptions' => ['style'=> 'text-align: center;'],
                        'headerOptions' => [
                            'width' => '10%',
                            'style'=> 'text-align: center;'
                        ]
                    ],
                    [
                        'header' => '操作',
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['align'=>'center'],
                        'headerOptions' => [
                            'width' => '16%',
                            'style'=> 'text-align: center;'
                        ],
                        'template' =>'{view} {update} {auth} {activate} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model, $key){
                                return Html::a('查看', $url, ['class' => "layui-btn layui-btn-primary layui-btn-xs layui-default-view"]);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('修改', Url::to(['update','id'=>$model->id]), ['class' => "layui-btn layui-btn-normal layui-btn-xs layui-default-update"]);
                            },
                            'auth' => function ($url, $model, $key) {
                                return Html::a('授权', Url::to(['assignment/view','id'=>$model->id]), ['class' => "layui-btn layui-btn-xs layui-default-update"]);
                            },
                            'activate' => function ($url, $model, $key) {
                                if($model->status==0){
                                    return Html::a('启用', Url::to(['active','id'=>$model->id]), ['class' => "layui-btn layui-btn-xs layui-btn-normal layui-default-active"]);
                                }else{
                                    return Html::a('禁用', Url::to(['inactive','id'=>$model->id]), ['class' => "layui-btn layui-btn-xs layui-btn-warm layui-default-inactive"]);
                                }
                            },

                            'delete' => function ($url, $model, $key) {
                                return Html::a('删除', $url, ['class' => "layui-btn layui-btn-danger layui-btn-xs layui-default-delete"]);
                            }
                        ]
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
