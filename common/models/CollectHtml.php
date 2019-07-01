<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "am_collect_html".
 *
 * @property string $id
 * @property int $c_id
 * @property int $p_id
 * @property string $title
 * @property string $thumb
 * @property string $url
 * @property string $addtime
 * @property int $is_down
 * @property int $is_export
 * @property string $content
 */
class CollectHtml extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'am_collect_html';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['c_id', 'p_id', 'addtime', 'is_down', 'is_export'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 60],
            [['thumb', 'url'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'c_id' => 'C ID',
            'p_id' => 'P ID',
            'title' => 'Title',
            'thumb' => 'Thumb',
            'url' => 'Url',
            'addtime' => 'Addtime',
            'is_down' => 'Is Down',
            'is_export' => 'Is Export',
            'content' => 'Content',
        ];
    }
}
