<?php

namespace common\models;

use Yii;

/**
 * Class Guestbook
 * @package common\models
 */
class Guestbook extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'am_guestbook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobile', 'addtime', 'status'], 'integer'],
            [['subject'], 'string', 'max' => 50],
            [['content', 'reply', 'info'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'content' => 'Content',
            'name' => 'Name',
            'mobile' => 'Mobile',
            'reply' => 'Reply',
            'info' => 'Info',
            'addtime' => 'Addtime',
            'status' => 'Status',
        ];
    }
}
