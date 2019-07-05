<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->registerJs($this->render('js/_script.js'));
$this->params['breadcrumbs'][] = '内容列表';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">内容列表</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?php  echo $this->render('_search',['model' => $searchModel,'channelDropdown' => $channelDropdown]); ?>

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
                        'attribute' => 'p_id',
                        'headerOptions' => [
                            'width' => '9%',
                            'style'=> 'text-align: center;'
                        ],
                        'contentOptions' => ['align'=>'center'],
                        'value' => function($model){
                            return $model->channel->name;
                        }
                    ],
                    [
                        'attribute' => 'title',
                        'format' => 'raw',
                        'value' => function($model){
                            $str = '';
                            if($model->thumb){
                                $str = ' <span class="layui-badge layui-bg-orange">图</span>';
                            }
                            if($model->flag){
                                $flag = explode(',',$model->flag);
                                foreach ($flag as $val){
                                    if($val == 't'){
                                        $str .= ' <span class="layui-badge">顶</span>';
                                    }elseif($val == 'c'){
                                        $str .= ' <span class="layui-badge layui-bg-green">推</span>';
                                    }elseif($val == 'h'){
                                        $str .= ' <span class="layui-badge layui-bg-blue">头</span>';
                                    }elseif($val == 'r'){
                                        $str .= ' <span class="layui-badge layui-bg-gray">跳</span>';
                                    }
                                }
                            }
                            return $model->title . $str;
                        }
                    ],
                    [
                        'attribute' => 'click',
                        'headerOptions' => [
                            'width' => '8%',
                            'style'=> 'text-align: center;'
                        ],
                        'contentOptions' => ['align'=>'center'],
                        'value' => function($model){
                            return $model->click;
                        }
                    ],
                    [
                        'attribute' => 'author',
                        'headerOptions' => [
                            'width' => '8%',
                            'style'=> 'text-align: center;'
                        ],
                        'contentOptions' => ['align'=>'center'],
                        'value' => function($model){
                            return $model->author;
                        }
                    ],
                    [
                        'attribute' => 'create_addtime',
                        'headerOptions' => [
                            'width' => '10%',
                            'style'=> 'text-align: center;'
                        ],
                        'contentOptions' => ['align'=>'center'],
                        'value' => function($model){
                            return $model->create_addtime;
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
                            'width' => '10%',
                            'style'=> 'text-align: center;'
                        ],
                        'template' =>'{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url) {
                                return Html::a('查看', $url, ['class' => "layui-btn layui-btn-xs layui-default-view"]);
                            },
                            'update' => function ($url,$model) {
                                return Html::a('编辑', \yii\helpers\Url::toRoute(['update','id'=>$model->id,'m_id'=>$model->m_id]), ['class' => "layui-btn layui-btn-normal layui-btn-xs layui-default-update"]);
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

