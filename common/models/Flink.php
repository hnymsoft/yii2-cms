<?php

namespace common\models;

use Yii;

/**
 * 友情链接
 * Class Flink
 * @package common\models
 */
class Flink extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%am_flink}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['typeid', 'order', 'status', 'addtime'], 'integer'],
            [['webname', 'linkurl'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 150],
            [['introduce'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'webname' => '网站名称',
            'linkurl' => '网站地址',
            'logo' => '网站Logo',
            'typeid' => '分类',
            'introduce' => '网站概况',
            'order' => '排列位置',
            'status' => '链接状态',
            'addtime' => '添加时间',
        ];
    }

    public function getFlinktype()
    {
        return $this->hasOne(Flinktype::className(), ['id' => 'typeid']);
    }
}
