<?php

namespace common\models;

use Yii;

/**
 * Class Channel
 * @package common\models
 */
class Channel extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'am_channel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'm_id','list_tpl', 'content_tpl', 'status','order' ,'level'], 'required'],
            [['id', 'm_id', 'p_id', 'status', 'order', 'create_addtime', 'update_addtime'], 'integer'],
            [['name', 'list_tpl', 'content_tpl', 'out_url', 'seo_title', 'create_user', 'update_user'], 'string', 'max' => 50],
            [['seo_keyword'], 'string', 'max' => 80],
            [['seo_description'], 'string', 'max' => 120],
            [['id'], 'unique'],
            [['out_url'],'url']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'm_id' => '模型名称',
            'p_id' => '父栏目',
            'name' => '栏目名称',
            'list_tpl' => '列表模版',
            'content_tpl' => '内容模版',
            'status' => '状态',
            'out_url' => '外部链接',
            'seo_title' => 'Seo标题',
            'seo_keyword' => 'Seo关键词',
            'seo_description' => 'Seo描述',
            'order' => '排序',
            'create_user' => '创建用户',
            'update_user' => '编辑用户',
            'create_addtime' => '创建时间',
            'update_addtime' => '编辑时间',
        ];
    }

    public function getModules(){
        return $this->hasOne(Module::className(),['id' => 'm_id']);
    }

    /**
     * 栏目树形结构
     * @param array $data
     * @param int $pid
     * @param int $level
     * @return array
     */
    public static function getDropdownChannelList($data = [],$pid = 0,$level = 0){
        static $tree = [];
        foreach($data as $v){
            if($v['p_id'] == $pid){
                $v['level'] = $level;
                if($pid == 0){
                    $arr['id'] = $v['id'];
                    $arr['name'] = $v['name'];
                }else{
                    $arr['id'] = $v['id'];
                    $arr['name'] = str_repeat('　', $level).'└─'.$v['name'];
                }
                $tree[] = $arr;
                static::getDropdownChannelList($data,$v['id'],$level+1);
            }
        }
        return $tree;
    }

    /**
     * 设置栏目级别
     * @param int $cid
     * @return int|mixed
     */
    public static function setChannelLevel($cid = 0){
        if(!$cid){
            return 0;
        }
        $info = static::findOne(['id' => $cid]);
        if(isset($info)){
            return $info->level + 1;
        }
        return 0;
    }
}
