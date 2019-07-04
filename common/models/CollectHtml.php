<?php

namespace common\models;

use Yii;

/**
 * Class CollectHtml
 * @package common\models
 */
class CollectHtml extends \yii\db\ActiveRecord
{
    public $ext_title;
    public $ext_keyword;
    public $ext_description;
    public $ext_content;
    public $ext_click;
    public $ext_source;
    public $ext_author;

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
            [['c_id', 'p_id', 'create_addtime', 'update_addtime','is_down', 'is_export'], 'integer'],
            [['content','hash'], 'string'],
            [['title'], 'string', 'max' => 60],
            [['url'], 'string', 'max' => 100],
            //扩展字段
            [['ext_click'],'integer'],
            [['ext_source','ext_author'],'string', 'max' => 10],
            [['ext_title','ext_keyword'],'string', 'max' => 60],
            [['ext_description'],'string', 'max' => 120],
            [['ext_content'],'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'c_id' => '节点名称',
            'p_id' => '栏目名称',
            'title' => '标题',
            'url' => '源地址',
            'create_addtime' => '加入时间',
            'update_addtime' => '更新时间',
            'is_down' => '是否下载',
            'is_export' => '是否入库',
            'content' => '内容',
            'hash' => '哈希值',
            //扩展字段
            'ext_title' => '标题',
            'ext_keyword' => '关键词',
            'ext_description' => '描述',
            'ext_content' => '内容',
            'ext_click' => '点击量',
            'ext_source' => '来源',
            'ext_author' => '作者',
        ];
    }

    /**
     * 模型关联
     * @return \yii\db\ActiveQuery
     */
    public function getCollect(){
        return $this->hasOne(Collect::className(),['id'=>'c_id']);
    }

    /**
     * afterFind 事件
     */
    public function afterFind(){
        parent::afterFind();
        $this->create_addtime = date('Y-m-d H:i:s',$this->create_addtime);
        $this->update_addtime = date('Y-m-d H:i:s',$this->update_addtime);
    }

    /**
     * 初始化采集列表入库
     * @param $id
     * @return string
     * @throws \yii\db\Exception
     */
    public static function initCollectList($id){
        $query = new Collect();
        $conf = json_decode($query->getConf($id),true);
        if(!$conf['status']){
            return ajaxReturnFailure($conf['message']);
        }
        $list = $query->getCollectionData($conf['data']['list']['list_url'],$conf['data']['list'],$conf['data']['options']);
        if(!$list){
            return ajaxReturnFailure('暂无采集数据！');
        }
        foreach ($list as $key => $val){
            $one = CollectHtml::findOne(['c_id'=>$id,'hash'=>md5($val['url'])]);
            if(!$one){
                $arr[$key]['c_id'] = $id;
                $arr[$key]['title'] = $val['title'];
                $arr[$key]['url'] = $val['url'];
                $arr[$key]['create_addtime'] = GTIME;
                $arr[$key]['hash'] = md5($val['url']);
            }
        }
        //批量添加采集网址
        if(!empty($arr)){
            $res = Yii::$app->db->createCommand()->batchInsert(CollectHtml::tableName(),['c_id','title','url','create_addtime','hash'],$arr)->execute();
            if(!$res){
                return ajaxReturnFailure('采集列表入库失败');
            }
            //采集成功回写当前节点网址数量
            $count = CollectHtml::find()->where(['c_id'=>$id])->count();
            Collect::updateAll([
                'num'=>$count,
                'update_addtime'=>GTIME,
                'update_user'=>Yii::$app->user->identity->username
            ],['id'=>$id]);
            return ajaxReturnSuccess('采集列表入库成功');
        }
        return ajaxReturnFailure('暂无新数据！');
    }

    /**
     * 数组增加指定前缀
     * @param $data
     * @param string $prefix
     * @return array
     */
    public static function addPrefix2Array($data,$prefix = '_pre'){
        $list = [];
        array_walk($data, function ($value, $key) use (&$list,$prefix) {
            $list[$prefix . $key] = $value;
        });
        return $list;
    }

    /**
     * 数组过滤指定前缀
     * @param $data
     * @param string $prefix
     * @return array
     */
    public static function filterPrefix2Array($data,$prefix = '_pre'){
        $list = [];
        array_walk($data, function ($value, $key) use (&$list,$prefix) {
            //包含ext_前缀直接去除
            if(strpos($key,$prefix) !== false){
                $list[mb_substr($key,4)] = $value;
            }else{
                $list[$key] = $value;
            }
        });
        return $list;
    }
}
