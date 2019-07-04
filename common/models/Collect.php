<?php

namespace common\models;

use QL\Ext\AbsoluteUrl;
use QL\Ext\CurlMulti;
use common\helpers\Uploader;
use QL\QueryList;
use Yii;

/**
 * Class Collect
 * @package common\models
 */
class Collect extends \yii\db\ActiveRecord
{
    //采集实例
    private $_query;
    private $_encode = 'utf-8';

    //扩展字段
    //基础
    public $is_head = 0;
    public $is_reverse = 0;
    public $is_ref = 0;
    public $is_ref_url;
    public $timeout = 30; //采集超时
    public $encoding = 0; //默认utf-8
    //列表
    public $list_url;
    public $list_range;
    public $list_rules_title;
    public $list_rules_url;
    public $list_rules_thumb;
    //内容
    public $content_range;
    public $content_rules_title;
    public $content_rules_kw = 'meta[name=keyword]';
    public $content_rules_desc = 'meta[name=description]';
    public $content_rules_content;
    public $content_rules_author;
    public $content_rules_source;
    public $content_rules_click;
    public $content_rules_addtime;
    public $content_rules_thumb;
    public $content_rules_content_filter;
    public $content_rules_author_filter;
    public $content_rules_source_filter;
    public $content_rules_click_filter;
    public $content_rules_addtime_filter;
    public $is_thumb = 0;

    /**
     * Collection constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->_query = QueryList::getInstance();
        $this->_query->use(AbsoluteUrl::class);
        $this->_query->use(CurlMulti::class,'curlMulti');
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'am_collect';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'encoding', 'baseconfig', 'listconfig', 'arcconfig', 'status'], 'required'],
            [['id', 'm_id','status', 'create_addtime', 'update_addtime','is_thumb','is_ref','is_head','is_reverse','timeout','encoding'], 'integer'],
            [['baseconfig', 'listconfig', 'arcconfig'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['create_user', 'update_user'], 'string', 'max' => 10],
            [['id'], 'unique'],
            //扩展字段
            [['list_url','list_rules_title','list_rules_url','content_rules_title','content_rules_content'],'required'],
            [['list_range','list_rules_thumb','content_range','content_rules_kw','content_rules_desc','content_rules_author','content_rules_source','content_rules_click','content_rules_addtime','content_rules_thumb'],'string','max' => 100],
            [['is_ref_url','list_url'],'url'],
            [['content_rules_content_filter','content_rules_author_filter','content_rules_source_filter','content_rules_click_filter','content_rules_addtime_filter'],'match','pattern'=>'/^[-].*$/','message'=>'{attribute}必须以"-"开头，多个使用空格分隔开']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'm_id' => '模型',
            'name' => '节点名称',
            'encoding' => '目标站编码',
            'num' => '数量',
            'baseconfig' => '基础配置',
            'listconfig' => '列表配置',
            'arcconfig' => '内容配置',
            'status' => '状态',
            'create_addtime' => '创建时间',
            'update_addtime' => '最后采集时间',
            'create_user' => '创建用户',
            'update_user' => '更新用户',
            //扩展字段
            'is_ref' => '防盗链模式',
            'is_ref_url' => '防盗链模式网址',
            'is_head' => '移除HEAD',
            'is_reverse' => '内容导入顺序',

            'timeout' => '超时时间',
            'list_range' => '列表采集区域',
            'list_url' => '采集链接',
            'list_rules_title' => '标题匹配规则',
            'list_rules_url' => '链接匹配规则',
            'list_rules_thumb' => '缩略图匹配规则',

            'content_range' => '内容范围',
            'content_rules_title' => '标题匹配规则',
            'content_rules_kw' => '关键词匹配规则',
            'content_rules_desc' => '描述匹配规则',
            'content_rules_content' => '内容匹配规则',
            'content_rules_content_filter' => '文章内容过滤规则',
            'content_rules_author' => '作者匹配规则',
            'content_rules_author_filter' => '文章作者过滤规则',
            'content_rules_source' => '来源匹配规则',
            'content_rules_source_filter' => '文章来源过滤规则',
            'content_rules_click' => '点击量匹配规则',
            'content_rules_click_filter' => '文章点击量过滤规则',
            'content_rules_addtime' => '发布时间匹配规则',
            'content_rules_addtime_filter' => '文章发布时间过滤规则',
            'is_thumb' => '提取缩略图'
        ];
    }

    /**
     * 模型关联
     * @return \yii\db\ActiveQuery
     */
    public function getModules(){
        return $this->hasOne(Module::className(),['id'=>'m_id']);
    }

    /**
     * afterFind 事件
     */
    public function afterFind(){
        parent::afterFind();
        $this->create_addtime = date('Y-m-d H:i:s',$this->create_addtime);
        $this->update_addtime = $this->update_addtime > 0 ? date('Y-m-d H:i:s',$this->update_addtime) : '--';
    }

    /**
     * 配置信息
     * @return mixed
     */
    public function getConf($id = 0){
        $model = Collect::findOne(['id'=>$id]);
        if(!$model){
            return ajaxReturnFailure('采集信息不存在！');
        }
        if($model->status != 1){
            return ajaxReturnFailure('当前节点已禁用，请使用其它节点采集！');
        }
        $conf['options'] = unserialize($model->baseconfig);
        $conf['options'] = array_merge($conf['options'],['subject'=>$model->name]);

        $conf['list'] = unserialize($model->listconfig);
        $conf['content'] = unserialize($model->arcconfig);
        return ajaxReturnSuccess('一切正常',$conf);
    }

    /**
     * 采集数据
     * @param $url
     * @param $data
     * @param $options
     * @return array|bool
     */
    public function getCollectionData($url,$data,$options){
        set_time_limit(0);

        if(!$url || !is_array($data)) return false;
        //Headers 设置
        $args['headers'] = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36',
        ];
        if(isset($options['is_ref']) && $options['is_ref'] == 1){
            $args['headers']['HTTP_REFERER'] = $options['is_ref_url'];
        }
        $this->_query->get($url,[],$args);
        //编码转换
        if(isset($options['encode']) && $options['encode'] != 'utf-8'){
            $this->_query->encoding($this->_encode,$options['encode']);

            //removeHead 调用后无法获取head数据
            if(isset($options['head']) && $options['head'] == 1){
                $this->_query->removeHead();
            }
        }
        $result = $this->_query->range($data['range'])->rules($data['rules'])->query(function ($item) use($url,$options){ //采集结果处理
            $parse_url = parse_url($url);
            $domain = "{$parse_url['scheme']}://{$parse_url['host']}";
            //相对链接改为绝对链接
            if(isset($item['url']) && !preg_match("/^(http:\/\/|https:\/\/).*$/",$item['url'])){
                $item['url'] = "{$domain}{$item['url']}";
            }
            if(isset($item['content'])){
                //a标签外部链接替换
                preg_match_all('/<a .*?href="(.*?)".*?>/is',$item['content'],$match);
                foreach ($match[1] as $aurl){
                    $item['content'] = str_replace($aurl,$domain,$item['content']);
                }

                //img标签本地化处理
                preg_match_all('#<img.*?src="([^"]*)"[^>]*>#i',$item['content'], $match);
                foreach($match[1] as $key => $imgurl){
                    $img_url = strpos($imgurl, 'http') !== false ? $imgurl : $domain.$imgurl;
                    $upload = new Uploader($img_url,$config = array(
                        "pathFormat" => "upload/article/{rand:10}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                        "maxSize" => 2048000,
                        "allowFiles" => ['.jpg','.gif','.bmp','.png']
                    ),'remote');
                    $info = $upload->getFileInfo();
                    $content = $item['content'];
                    if($info['state'] == 'SUCCESS'){
                        if($options['is_thumb'] && $key == 0){ //是否抓取内容第一张图作为缩略图
                            $item['thumb'] = '/'.$info['url'];
                        }
                        $content = str_replace($imgurl,'/'.$info['url'],$item['content']);
                    }
                    $item['content'] = $content;
                }

                //详情路径
                $item['url'] = $url;
            }
            if(!empty($item['addtime'])){
                preg_match("'\d{4}[/-]\d{1,2}[/-]\d{1,2} (\d{1,2}\:\d{1,2}\:\d{1,2})?'is",trim($item['addtime']),$match);
                $item['addtime'] = isset($match[0]) ? $match[0] : date('Y-m-d H:i:s');
            }
            if (isset($item['click'])){
                preg_match("/\d/",$item['click'],$match);
                $item['click'] = isset($item['click']) ? $match[0] : 0;
            }
            return $item;
        })->getData();

        //采集顺序
        if(isset($options['is_reverse']) && $options['is_reverse'] == 'desc'){
            return $result->reverse()->all();
        }else{
            return $result->all();
        }
    }

    /**
     * 采集数据（多线程）
     */
    public function getMultiCollectionData(){

    }
}
