<?php

namespace common\models;

use Yii;

/**
 * 用户等级
 * Class UserRank
 * @package common\models
 */
class MemberRank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%am_member_rank}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'score', 'discount', 'status'], 'required'],
            [['score', 'status'], 'integer'],
            [['discount'], 'number'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'score' => '积分区间',
            'discount' => '折扣',
            'status' => '状态',
        ];
    }
}
