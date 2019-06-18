<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <a href="<?=Yii::$app->request->referrer?>" class="layui-btn layui-btn-primary layui-btn-sm">返回上一页</a>
        </div>
        <div class="layui-card-body">
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

<style>table tr td p{line-height: 25px;}</style>
