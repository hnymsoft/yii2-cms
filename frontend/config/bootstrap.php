<?php

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');

Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

//自定义
Yii::setAlias('@webRoot', dirname(dirname(__DIR__)));
Yii::setAlias('@rootPath', dirname(dirname(__DIR__)));
Yii::setAlias('@statics', "/statics"); //可配置成域名，也可以配置成物理路径
Yii::setAlias('@vendor', dirname(dirname(__DIR__)) . '/vendor');
