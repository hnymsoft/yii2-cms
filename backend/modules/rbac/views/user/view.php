<?php
use yii\widgets\DetailView;
?>
<div class="layui-fluid">
        <?=DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'layui-table','style'=>'margin-top:0'],
            'attributes' => [
                'username',
                'nickname',
                [
                    "attribute"=>"head_pic",
                    "format"=>[
                        "image",
                        [
                            "width"=>"90px",
                            "height"=>"90px",
                            "class" => "layui-circle"
                        ],
                    ],
                ],
                'email:email',
                'created_at:date',
                'status',
            ],
            'template' => '<tr><th width="90px;">{label}</th><td>{value}</td></tr>',
        ])
        ?>
</div>
