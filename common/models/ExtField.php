<?php

namespace common\models;

use Yii;

/**
 * Class ExtField
 * @package common\models
 */
class ExtField extends BaseModel
{
    public static $input_type = [
        1 => '单行文本',
        2 => '多行文本',
        3 => '单选按钮',
        4 => '多选按钮',
        5 => '图片上传',
        6 => '附件上传',
        7 => '日期选择'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'am_ext_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'm_id', 'f_type', 'name', 'item'], 'required'],
            [['id', 'm_id', 'f_type', 'order'], 'integer'],
            [['name','item'], 'string', 'max' => 50],
            [['value', 'desc'], 'string', 'max' => 100],
            [['id'], 'unique'],
            [['item'],'match','pattern' => '/^[a-zA-Z]([_a-zA-Z]{3,10})$/','message' => '字段名称必须为字母、下划线等']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'm_id' => '模型类型',
            'f_type' => '字段类型',
            'name' => '表单提示文字',
            'item' => '字段名称',
            'value' => '字段内容',
            'desc' => '字段描述',
            'order' => '排序',
        ];
    }

    public function getModules(){
        return $this->hasOne(Module::className(),['id' => 'm_id']);
    }
}
