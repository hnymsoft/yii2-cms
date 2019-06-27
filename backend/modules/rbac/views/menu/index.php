<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\assets\LayuiAsset;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel rbac\models\searchs\Menu */

LayuiAsset::register($this); 
$this->registerJs($this->render('js/index.js'));
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" id="main-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this">菜单列表</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <?php echo $this->render('_search',['model' => $searchModel]); ?>

                        <?php Pjax::begin(); ?>
                        <?=GridView::widget([
                            'dataProvider' => $dataProvider,
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
                                    'class' => 'backend\widgets\CheckboxColumn',
                                    'checkboxOptions' => ['lay-skin'=>'primary','lay-filter'=>'choose'],
                                    'headerOptions' => ['width'=>'50','style'=> 'text-align: center;'],
                                    'contentOptions' => ['style'=> 'text-align: center;']
                                ],
                                'name',
                                [
                                    'attribute' => 'menuParent.name',
                                    'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                                        'class' => 'form-control', 'id' => null
                                    ]),
                                    'label' => '父栏目'
                                ],
                                'route',
                                [
                                    'attribute' => 'order',
                                    'contentOptions' => ['style'=> 'text-align: center;'],
                                    'headerOptions' => [
                                        'width' => '6%',
                                        'style'=> 'text-align: center;'
                                    ],
                                    'value' => function($model){
                                        return $model->order;
                                    }
                                ],
                                [
                                    'header' => '操作',
                                    'class' => 'yii\grid\ActionColumn',
                                    'contentOptions' => ['class'=>'text-center'],
                                    'headerOptions' => [
                                        'width' => '12%',
                                        'style'=> 'text-align: center;'
                                    ],
                                    'template' =>'{view} {update} {delete}',
                                    'buttons' => [
                                        'view' => function ($url, $model, $key){
                                            return Html::a('查看', Url::to(['view','id'=>$model->id]), ['class' => "layui-btn layui-btn-xs layui-default-view"]);
                                        },
                                        'update' => function ($url, $model, $key) {
                                            return Html::a('编辑', Url::to(['update','id'=>$model->id]), ['class' => "layui-btn layui-btn-normal layui-btn-xs layui-default-update"]);
                                        },
                                        'delete' => function ($url, $model, $key) {
                                            return Html::a('删除', Url::to(['delete','id'=>$model->id]), ['class' => "layui-btn layui-btn-danger layui-btn-xs layui-default-delete"]);
                                        }
                                    ]
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
