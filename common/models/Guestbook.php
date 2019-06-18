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
            'subject' => '标题',
            'content' => '留言内容',
            'name' => '姓名',
            'mobile' => '手机号码',
            'reply' => '回复',
            'info' => '设备信息',
            'addtime' => '留言时间',
            'status' => '状态',
        ];
    }

    /**
     * afterFind 事件
     */
    public function afterFind(){
        parent::afterFind();
        $this->addtime = date('Y-m-d H:i:s',$this->addtime);
    }
}
