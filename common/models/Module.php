<?php

namespace common\models;

use Yii;

/**
 * Class Module
 * @package common\models
 */
class Module extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'am_modules';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'list_tpl', 'content_tpl', 'create_user', 'update_user', 'create_addtime', 'update_addtime'], 'required'],
            [['type', 'status', 'is_system', 'create_addtime', 'update_addtime'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['list_tpl', 'content_tpl'], 'string', 'max' => 80],
            [['create_user', 'update_user'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '模型名称',
            'type' => '模型类型',
            'list_tpl' => '列表页模板',
            'content_tpl' => '内容页模版',
            'status' => '是否启用',
            'is_system' => '是否系统模型',
            'create_user' => '创建人',
            'update_user' => '修改人',
            'create_addtime' => '创建时间',
            'update_addtime' => '修改时间',
        ];
    }
}
