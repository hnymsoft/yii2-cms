<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->registerJs($this->render('js/_script.js'));
$this->params['breadcrumbs'][] = ['label' => '系统管理','url'=>\yii\helpers\Url::toRoute(['setting/index'])];
$this->params['breadcrumbs'][] = '数据备份';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">数据备份</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div class="search-box">
                <div class="layui-inline">
                    <?=Html::a('开始备份 <span class="fa fa-refresh layui-anim" style="display: none"></span>','javascript:;',['class' => 'layui-btn','id'=>'backup']);?>

                    <?=Html::a('还原管理',\yii\helpers\Url::to(['import/index']),['class' => 'layui-btn layui-btn-primary']);?>
                </div>
            </div>

            <?php \yii\widgets\ActiveForm::begin(['id' => 'export-form', 'action' => \yii\helpers\Url::to(['backup'])])?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'grid-view layui-form','lay-filter'=>'allChoose','style'=>'overflow:auto', 'id' => 'grid-view'],
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
                        'class' => 'backend\widgets\CheckboxColumn',
                        'name' => 'table',
                        'checkboxOptions' =>function($model){
                            return ['lay-skin'=>'primary','lay-filter'=>'choose','value' => $model['name']];
                        },
                        'headerOptions' => ['width'=>'50','style'=> 'text-align: center;'],
                        'contentOptions' => ['style'=> 'text-align: center;']
                    ],
                    'name:text:表名',
                    'engine:text:引擎',
                    [
                        'attribute' => 'rows',
                        'label' => '记录数',
                        'headerOptions' => ['width'=>'220','style'=> 'text-align: center;'],
                        'contentOptions' => ['style'=> 'text-align: center;'],
                    ],
                    [
                        'attribute' => 'data_length',
                        'label' => '数据',
                        'headerOptions' => ['width'=>'220','style'=> 'text-align: center;'],
                        'contentOptions' => ['style'=> 'text-align: center;'],
                        'value' => function ($model) {
                            return Yii::$app->formatter->asShortSize($model['data_length']);
                        }
                    ],
                    'data_free:text:碎片',
                    'collation:text:字符集',
                    [
                        'header' => '操作',
                        'headerOptions' => ['width'=>'150','style'=> 'text-align: center;'],
                        'contentOptions' => ['style'=> 'text-align: center;'],
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{a} {b}',
                        'buttons' => [
                            'a' => function ($url, $model, $key) {
                                if(in_array($model['engine'],['MyISAM','BDB','InnoDB'])) {
                                    return Html::a('优化表',
                                        ['export/optimize', 'tables' => $model['name']],
                                        [
                                            'class' => 'layui-btn layui-btn-xs table_optimize',
                                            'id' => 'optimize'
                                        ]
                                    );
                                }
                            },
                            'b' => function ($url, $model, $key) {
                                if(in_array($model['engine'],['MyISAM','ARCHIVE'])){
                                    return Html::a('修复表',
                                        ['export/repair', 'tables' => $model['name']],
                                        [
                                            'class' => 'layui-btn layui-btn-normal layui-btn-xs table_repair',
                                            'id' => 'repair'
                                        ]
                                    );
                                }
                            }
                        ]
                    ],
                ],
            ]); ?>
            <?php \yii\widgets\ActiveForm::end()?>
        </div>
    </div>
</div>

