<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\AdPosition */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ad Positions';
$this->params['breadcrumbs'][] = $this->title;
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
                    'position_id',
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
                                return Html::a('查看广告', \yii\helpers\Url::to(['ad/index','Ad[position_id]'=>$model->position_id]), ['class' => "layui-btn layui-btn-xs layui-default-view"]);
                            },
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
