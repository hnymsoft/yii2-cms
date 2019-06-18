<?php

namespace common\models;

use Yii;

/**
 * 广告位
 * Class AdPosition
 * @package common\models
 */
class AdPosition extends BaseModel
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
            [['position_name','ad_width','ad_height'], 'required'],
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
            'id' => 'ID',
            'position_name' => '广告位名称',
            'ad_width' => '广告位宽度',
            'ad_height' => '广告位高度',
            'position_desc' => '广告位描述',
            'position_style' => '广告位代码',
        ];
    }

    /**
     * 生成广告代码
     * @param $id
     * @return bool
     */
    public static function genAdvertCode($id,$pid){
        $modelAdpostion = static::findOne($pid);
        $modelAd = Ad::findOne(['id'=>$id,'position_id'=>$pid,'enabled'=>1]);
        if(!$modelAdpostion || !$modelAd){
            return false;
        }
        //根据媒体类型生成不同的广告
        switch ($modelAd->media_type){
            case 0: //图片
                $ad_str = "<a href='{$modelAd->ad_link}' target='_blank'><img src='{$modelAd->ad_code}' width='{$modelAdpostion->ad_width}' height='{$modelAdpostion->ad_height}' /></a>";
                break;
            case 1: //文字
                $ad_str = "<a href='{$modelAd->ad_link}' target='_blank'>{$modelAd->ad_code}</a>";
                break;
            case 2: //代码
                $ad_str = $modelAd->ad_code;
                break;
            default:
                $ad_str = '';
                break;
        }
        $ad_body = "<!--\r\ndocument.write(\"{$ad_str}\");\r\n-->\r\n";
        $filename = "ad_{$pid}.js";
        $path = Yii::getAlias('@frontend')."/web/plus/";
        if (!is_dir($path)){
            mkdir($path,0777);
        }
        if(file_put_contents($path . $filename, $ad_body)){
            $modelAdpostion->position_style = "<script src='/plus/{$filename}' type='text/javascript'></script>";
            if($modelAdpostion->save(false)){
                return true;
            }
        }
        return false;
    }
}
