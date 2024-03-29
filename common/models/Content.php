<?php

namespace common\models;

use Yii;

/**
 * Class Content
 * @package common\models
 */
class Content extends BaseModel
{
    public $seconds = 3; //针对采集数据每批次导入的条数

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
            [['id', 'p_id', 'm_id', 'title', 'keywords', 'description', 'author', 'source'], 'required'],
            [['id', 'p_id', 'm_id', 'click', 'status', 'create_addtime', 'update_addtime'], 'integer'],
            [['money'], 'number'],
            [['color', 'title', 'keywords', 'source', 'create_user', 'update_user','flag','subtitle','tags'], 'string', 'max' => 50],
            [['out_url'],'string','max'=>120],
            [['out_url'],'url'],
            [['description'], 'string', 'max' => 12],
            [['thumb'], 'string', 'max' => 80],
            [['author'], 'string', 'max' => 20],
            [['id'], 'unique'],
            //扩展字段
            [['seconds'],'required'],
            [['seconds'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'p_id' => '栏目',
            'm_id' => '模型',
            'color' => '标题颜色',
            'title' => '标题',
            'subtitle' => '副标题',
            'tags' => 'Tags',
            'keywords' => 'SEO关键词',
            'description' => 'SEO描述',
            'thumb' => '缩略图',
            'money' => '价格',
            'flag' => '自定义属性',
            'author' => '作者',
            'click' => '访问量',
            'source' => '来源',
            'status' => '状态',
            'out_url' => '跳转链接',
            'create_addtime' => '添加时间',
            'update_addtime' => '更新时间',
            'pubdate_addtime' => '发布时间',
            'create_user' => '添加操作人',
            'update_user' => '更新操作人',

            'seconds' => '入库间隔秒数'
        ];
    }

    public function getChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'p_id']);
    }

    /**
     * afterFind 事件
     */
    public function afterFind(){
        parent::afterFind();
        $this->create_addtime = date('Y-m-d H:i:s',$this->create_addtime);
        $this->update_addtime = date('Y-m-d H:i:s',$this->update_addtime);
    }
}
