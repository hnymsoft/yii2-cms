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
                    <li class="layui-this">数据备份</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <div class="search-box">
                            <div class="layui-inline">
                                <?=Html::a('备份管理',\yii\helpers\Url::to(['export/index']),['class' => 'layui-btn layui-btn-primary']);?>
                            </div>
                        </div>

                        <?php \yii\widgets\ActiveForm::begin(['id' => 'export-form', 'action' => \yii\helpers\Url::to(['backup'])])?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'options' => ['class' => 'grid-view','lay-filter'=>'allChoose','style'=>'overflow:auto', 'id' => 'grid-view'],
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
                                    'attribute' => 'time',
                                    'label' => '备份名称',
                                    'value' => function($model) {
                                        return date('Ymd-His', $model['time']);
                                    }
                                ],
                                [
                                    'attribute' => 'part',
                                    'label' => '卷数',
                                    'headerOptions' => ['width'=>'220','style'=> 'text-align: center;'],
                                    'contentOptions' => ['style'=> 'text-align: center;'],
                                ],
                                [
                                    'attribute' => 'compress',
                                    'label' => '压缩方式',
                                    'headerOptions' => ['width'=>'220','style'=> 'text-align: center;'],
                                    'contentOptions' => ['style'=> 'text-align: center;'],
                                ],
                                [
                                    'attribute' => 'size',
                                    'label' => '数据大小',
                                    'headerOptions' => ['width'=>'220','style'=> 'text-align: center;'],
                                    'contentOptions' => ['style'=> 'text-align: center;'],
                                    'value' => function($model) {
                                        return Yii::$app->formatter->asShortSize($model['size']);
                                    }
                                ],
                                [
                                    'header' => '操作',
                                    'headerOptions' => ['width'=>'180','style'=> 'text-align: center;'],
                                    'contentOptions' => ['style'=> 'text-align: center;'],
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{a} {b}',
                                    'buttons' => [
                                        'a' => function ($url, $model, $key) {
                                            return Html::a('还原 <span class="fa fa-refresh layui-anim" style="display: none"></span>',
                                                \yii\helpers\Url::toRoute(['restore','time'=>$model['time']]),
                                                ['class' => 'layui-btn layui-btn-xs','id'=>'restore']
                                            );
                                        },
                                        'b' => function ($url, $model, $key) {
                                            return Html::a('删除',
                                                \yii\helpers\Url::toRoute(['delete','time'=>$model['time']]),
                                                [
                                                    'class' => 'layui-btn layui-btn-normal layui-btn-xs',
                                                    'id' => 'delete'
                                                ]
                                            );
                                        }
                                    ]
                                ],
                            ],
                        ]); ?>
                        <?php \yii\widgets\ActiveForm::end()?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
