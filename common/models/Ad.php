<?php

namespace common\models;

use Yii;

/**
 * 广告
 * Class Ad
 * @package common\models
 */
class Ad extends BaseModel
{
    public $font_content,$img_link,$code_content;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%am_ad}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position_id', 'media_type', 'click_count', 'enabled'], 'integer'],
            [['ad_code','position_id','ad_name','start_time','end_time'], 'required'],
            [['ad_code'], 'string'],
            [['ad_name', 'link_man', 'link_email', 'link_phone'], 'string', 'max' => 60],
            [['ad_link'], 'string', 'max' => 255],
            //[['ad_link'],'url']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position_id' => '广告位置',
            'media_type' => '媒介类型',
            'ad_name' => '广告名称',
            'ad_link' => '广告链接',
            'ad_code' => '广告内容',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'link_man' => '联系人',
            'link_email' => '联系邮箱',
            'link_phone' => '联系电话',
            'click_count' => '点击数量',
            'enabled' => '是否开启',
            'font_content' => '广告内容',
            'img_link' => '图片地址',
            'code_content' => '广告代码'
        ];
    }

    public function getAdPosition()
    {
        return $this->hasOne(AdPosition::className(), ['id' => 'position_id']);
    }

    /**
     * afterFind 事件
     */
    public function afterFind(){
        parent::afterFind();
        $this->start_time = date('Y-m-d',$this->start_time);
        $this->end_time = date('Y-m-d',$this->end_time);
    }
}
