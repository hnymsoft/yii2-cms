<?php
namespace common\models;

/**
 * 分类
 * Class Flinktype
 * @package common\models
 */
class Flinktype extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%am_flinktype}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['typename'], 'string', 'max' => 50],
            [['order'],'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'typename' => '分类名称',
            'order' => '分类排序'
        ];
    }
}
