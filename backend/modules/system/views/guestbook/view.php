<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
$this->params['breadcrumbs'][] = ['label' => '扩展管理','url'=>\yii\helpers\Url::toRoute(['flink/index'])];
$this->params['breadcrumbs'][] = ['label' => '留言列表','url'=>\yii\helpers\Url::toRoute(['guestbook/index'])];
$this->params['breadcrumbs'][] = '详情';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">留言详情</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div class="form-box-dialog">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'layui-table','style'=>'margin-top:0'],
                'template' => '<tr><th width="90px;">{label}</th><td>{value}</td></tr>',
                'attributes' => [
                    'id',
                    'subject',
                    'name',
                    'mobile',
                    [
                        'label' => '留言内容',
                        'format' => 'raw',
                        'value' => function($model){
                            return "<p>{$model->content}</p>
                        <p><font color='red'>管理员回复：</font>{$model->reply}</p>";
                        }
                    ],
                    'addtime',
                    [
                        'label' => '前台显示',
                        'contentOptions' => ['align'=>'center'],
                        'headerOptions' => [
                            'width' => '10%',
                            'style'=> 'text-align: center;'
                        ],
                        'format' => 'raw',
                        'value' => function($model){
                            return $model->status == 1 ? '<font color="green">是</font>' : '<font color="red">否</font>';
                        }
                    ],
                ],
            ]) ?>
            </div>
        </div>
    </div>
</div>
