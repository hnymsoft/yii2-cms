<?php

namespace common\models;

use Yii;

/**
 * 广告位
 * Class AdPosition
 * @package common\models
 */
class AdPosition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%am_ad_position}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ad_width', 'ad_height'], 'integer'],
            [['position_style'], 'required'],
            [['position_style'], 'string'],
            [['position_name'], 'string', 'max' => 60],
            [['position_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'position_id' => 'ID',
            'position_name' => '广告位名称',
            'ad_width' => '广告位宽度',
            'ad_height' => '广告位高度',
            'position_desc' => '广告位描述',
            'position_style' => '广告位代码',
        ];
    }
}
