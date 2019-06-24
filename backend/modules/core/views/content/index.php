<?php

use yii\helpers\Html;
use yii\grid\GridView;
$this->registerJs($this->render('js/_script.js'));
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <?php  echo $this->render('_search',['model' => $searchModel,'channelDropdown' => $channelDropdown]); ?>
        </div>
        <div class="layui-card-body">
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
                    'value' => function($model){
                        return $model->title;
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
                        'width' => '12%',
                        'style'=> 'text-align: center;'
                    ],
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
                            return Html::a('修改', \yii\helpers\Url::toRoute(['update','id'=>$model->id,'m_id'=>$model->m_id]), ['class' => "layui-btn layui-btn-normal layui-btn-xs layui-default-update"]);
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
