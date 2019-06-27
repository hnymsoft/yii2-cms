<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->registerJs($this->render('js/_script.js'));
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" id="main-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this">会员列表</li>
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
                                            $conf = \common\models\Setting::getConfInfo('cfg_domain');
                                            $url = preg_match("/^http(s)?:\\/\\/.+/",$model->head_pic) ? $model->head_pic : $conf->value .'/'. $model->head_pic;
                                            return Html::img($url,['class'=>'layui-circle','width'=>'35px','height'=>'35px']);
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