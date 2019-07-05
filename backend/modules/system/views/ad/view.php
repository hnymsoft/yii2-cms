<?php
use yii\widgets\DetailView;
$this->params['breadcrumbs'][] = ['label' => '广告列表','url'=>\yii\helpers\Url::toRoute(['ad/index'])];
$this->params['breadcrumbs'][] = '详情';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">广告详情</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'layui-table','style'=>'margin-top:0'],
                'template' => '<tr><th width="90px;">{label}</th><td>{value}</td></tr>',
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
            ]) ?>
        </div>
    </div>
</div>
