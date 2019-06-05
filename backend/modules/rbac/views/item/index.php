<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->registerJs($this->render('js/index.js'));
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
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
                    'attribute' => 'name',
                    'label' => Yii::t('rbac-admin', 'Name'),
                ],
                [
                    'attribute' => 'ruleName',
                    'label' => Yii::t('rbac-admin', 'Rule Name'),
                ],
                [
                    'attribute' => 'description',
                    'label' => Yii::t('rbac-admin', 'Description'),
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
                        'view' => function ($url){
                            $name = Yii::$app->controller->id == 'permission' ? '查看' : '分配权限';
                            return Html::a($name, $url, ['class' => "layui-btn layui-btn-xs layui-default-view"]);
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
        ])
        ?>
        </div>
    </div>
</div>
