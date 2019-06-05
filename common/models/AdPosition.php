<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%am_ad_position}}".
 *
 * @property int $position_id
 * @property string $position_name
 * @property int $ad_width
 * @property int $ad_height
 * @property string $position_desc
 * @property string $position_style
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
            'position_id' => 'Position ID',
            'position_name' => 'Position Name',
            'ad_width' => 'Ad Width',
            'ad_height' => 'Ad Height',
            'position_desc' => 'Position Desc',
            'position_style' => 'Position Style',
        ];
    }
}
