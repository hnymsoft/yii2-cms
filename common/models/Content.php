<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "am_content".
 *
 * @property int $id
 * @property int $type_id
 * @property int $module_id
 * @property string $color
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $thumb
 * @property string $money
 * @property int $flag
 * @property string $auther
 * @property int $click
 * @property string $source
 * @property int $status
 * @property int $create_addtime
 * @property int $update_addtime
 * @property string $create_user
 * @property string $update_user
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'am_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'module_id', 'color', 'title', 'keywords', 'description', 'thumb', 'auther', 'source', 'update_addtime', 'create_user', 'update_user'], 'required'],
            [['id', 'type_id', 'module_id', 'flag', 'click', 'status', 'create_addtime', 'update_addtime'], 'integer'],
            [['money'], 'number'],
            [['color', 'title', 'keywords', 'source', 'create_user', 'update_user'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 12],
            [['thumb'], 'string', 'max' => 80],
            [['auther'], 'string', 'max' => 20],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'module_id' => 'Module ID',
            'color' => 'Color',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'thumb' => 'Thumb',
            'money' => 'Money',
            'flag' => 'Flag',
            'auther' => 'Auther',
            'click' => 'Click',
            'source' => 'Source',
            'status' => 'Status',
            'create_addtime' => 'Create Addtime',
            'update_addtime' => 'Update Addtime',
            'create_user' => 'Create User',
            'update_user' => 'Update User',
        ];
    }
}
