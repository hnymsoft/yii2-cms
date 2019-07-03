<?php

namespace common\models;

use Yii;

/**
 * Class CollectHtml
 * @package common\models
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
            [['content','hash'], 'string'],
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
            'hash' => 'hash'
        ];
    }

    /**
     * 初始化采集列表入库
     * @param $id
     * @return string
     * @throws \yii\db\Exception
     */
    public static function initCollectList($id){
        $query = new Collect();
        $conf = $query->getConf($id);
        $list = $query->getCollectionData($conf['list']['list_url'],$conf['list'],$conf['options']);
        if(!$list){
            return ajaxReturnFailure('暂无采集数据！');
        }
        foreach ($list as $key => $val){
            $one = CollectHtml::findOne(['c_id'=>$id,'hash'=>md5($val['url'])]);
            if(!$one){
                $arr[$key]['c_id'] = $id;
                $arr[$key]['title'] = $val['title'];
                $arr[$key]['url'] = $val['url'];
                $arr[$key]['addtime'] = GTIME;
                $arr[$key]['hash'] = md5($val['url']);
            }
        }
        //批量添加采集网址
        if(!empty($arr)){
            $res = Yii::$app->db->createCommand()->batchInsert(CollectHtml::tableName(),['c_id','title','url','addtime','hash'],$arr)->execute();
            if(!$res){
                return ajaxReturnFailure('采集列表入库失败');
            }
            return ajaxReturnSuccess('采集列表入库成功');
        }
        return ajaxReturnFailure('暂无新数据！');
    }
}
