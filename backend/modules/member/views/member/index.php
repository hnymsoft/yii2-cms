<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->registerJs($this->render('js/_script.js'));
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <?php  echo $this->render('_search',['model' => $searchModel]); ?>
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
                'id',
                [
                    'label' => '头像',
                    'contentOptions' => ['align'=>'center'],
                    'headerOptions' => [
                        'width' => '5%',
                        'style'=> 'text-align: center;'
                    ],
                    'format' => 'raw',
                    'value' => function($model){
                        if($model->head_pic){
                            return Html::img($model->head_pic,['class'=>'layui-circle','width'=>'45px','height'=>'45px']);
                        }else{
                            return '--';
                        }
                    }
                ],
                'username',
                'nickname',
                [
                    'label' => '会员级别',
                    'value' => function($model){
                        return $model->memberrank->name;
                    }
                ],
                'mobile',
                'email:email',
                'integral',
                'balance',
                'created_at',
                [
                    'attribute' => 'status',
                    'headerOptions' => [
                        'width' => '7%',
                        'style'=> 'text-align: center;'
                    ],
                    'contentOptions' => ['align'=>'center'],
                    'format' => 'raw',
                    'value' => function($model){
                        $status = $model->status == 10 ? true : false;
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