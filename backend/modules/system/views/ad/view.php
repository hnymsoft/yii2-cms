<?php
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
                'attributes' => [
                    'ad_name',
                    [
                        'label' => '广告位置',
                        'value' => function($model){
                            return $model->adPosition->position_name;
                        }
                    ],
                    [
                        'label' => '媒体类型',
                        'value' => function($model){
                             if($model->media_type == 1){
                                 return '文字';
                             }elseif ($model->media_type == 2){
                                 return '代码';
                             }elseif ($model->media_type == 0){
                                 return '图片';
                             }
                        }
                    ],
                    'start_time:date',
                    'end_time:date',
                    'ad_link',
                    'ad_code:ntext',
                    'click_count',
                    [
                        'label' => '是否开启',
                        'value' => function($model){
                            return $model['enabled'] == 1 ? '开启' : '关闭';
                        }
                    ],
                    [
                        'label' => '广告联系人',
                        'value' => function($model){
                            return $model['link_man'] ? $model['link_man'] : '--';
                        }
                    ],
                    [
                        'label' => '联系人Email',
                        'value' => function($model){
                            return $model['link_email'] ? $model['link_email'] : '--';
                        }
                    ],
                    [
                        'label' => '联系电话',
                        'value' => function($model){
                            return $model['link_phone'] ? $model['link_phone'] : '--';
                        }
                    ]
                ],
                'template' => '<tr><th width="90px;">{label}</th><td>{value}</td></tr>',
            ]) ?>
            </div>
        </div>
    </div>
</div>