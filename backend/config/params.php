<?php
return [
    //数据备份配置
    'DATA_BACKUP' => [
        'PATH' => Yii::getAlias('@backend') . '/backup/',
        'PART_SIZE' => 20971520,
        'COMPRESS' => 1,
        'COMPRESS_LEVEL' => 9,
    ]
];
