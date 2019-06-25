<?php

namespace common\models;

use Yii;

/**
 * Class Slider
 * @package common\models
 */
class Slider extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'am_slider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pic', 'link', 'title','status'], 'required'],
            [['order', 'create_time', 'update_time','status'], 'integer'],
            [['create_user'], 'safe'],
            [['pic', 'title', 'subtitle'], 'string', 'max' => 50],
            [['link'], 'string', 'max' => 80],
            [['link'], 'url'],
            [['update_user'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pic' => '图片',
            'link' => '链接',
            'title' => '标题',
            'subtitle' => '子标题',
            'order' => '排序',
            'status' => '状态',
            'create_user' => '添加帐号',
            'update_user' => '更新帐号',
            'create_time' => '添加时间',
            'update_time' => '更新时间',
        ];
    }
}
