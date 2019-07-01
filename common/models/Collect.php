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
    public $head = 0;
    public $reverse = 0;
    public $is_guard = 0;
    public $referer;
    public $timeout = 10;
    //列表
    public $list_url;
    public $list_range;
    public $list_rules_title;
    public $list_rules_url;
    public $list_rules_thumb;
    //内容
    public $content_range;
    public $content_rules_title;
    public $content_rules_kw;
    public $content_rules_desc;
    public $content_rules_content;
    public $content_rules_author;
    public $content_rules_source;
    public $content_rules_click;
    public $content_rules_addtime;

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
            [['id', 'name', 'encoding', 'baseconfig', 'listconfig', 'arcconfig', 'status', 'create_addtime', 'update_addtime', 'create_user', 'update_user'], 'required'],
            [['id', 'm_id', 'num', 'status', 'create_addtime', 'update_addtime'], 'integer'],
            [['baseconfig', 'listconfig', 'arcconfig'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['encoding', 'create_user', 'update_user'], 'string', 'max' => 10],
            [['id'], 'unique'],
            //扩展字段
            [['list_url','list_rules_title','list_rules_url','content_rules_title','content_rules_content'],'required'],
            [['referer','list_url','list_rules_url'],'url']
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
            'update_addtime' => '更新时间',
            'create_user' => '创建用户',
            'update_user' => '更新用户',
            //扩展字段
            'is_guard' => '防盗链模式',
            'head' => '移除HEAD',
            'reverse' => '内容导入顺序',

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
            'content_rules_author' => '作者匹配规则',
            'content_rules_source' => '来源匹配规则',
            'content_rules_click' => '点击量匹配规则',
            'content_rules_addtime' => '发布时间匹配规则',
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
        $this->create_addtime = date('Y-m-d',$this->create_addtime);
        $this->update_addtime = date('Y-m-d',$this->update_addtime);
    }

    /**
     * 配置信息
     * @return mixed
     */
    public function getConf(){
        $conf['options'] = [
            'head' => 0, //0 不移除 1 移除
            'encode' => '',      //utf-8、gb2312、gbk
            'reverse' => 'desc',   //asc升序   desc降序
            'referer' => 'http://www.dedecms.com', //引用地址
        ];
        $conf['list'] = [
            'url' => 'https://www.xinqii.cn/list/news.html',
            'range' => '.news-container .wow',
            'rules' => [
                'title' => ['.n-right .n-title','text'],
                'url' => ['a','href'],
                'thumb' => ['img','src']
            ]
        ];
        $conf['content'] = [
            'range' => '',
            'rules' => [
                'title' => ['.newscontentbox h4','text'],
                'kw' => ['meta[name=keywords]','content'],
                'desc' => ['meta[name=description]','content'],
                'content' => ['.newscontentbox .article-content','html'],
                'author' => ['author','text'],
                'source' => ['source','text'],
                'click' => ['.article-tags span:eq(1)','text'],
                'addtime' => ['.article-tags span:eq(0)','text']
            ]
        ];
        return $conf;
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
        if(!empty($options['referer'])){
            $args['headers']['Referer'] = $options['referer'];
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
            }elseif(isset($item['content'])){
                //a标签外部链接替换
                preg_match_all('/<a .*?href="(.*?)".*?>/is',$item['content'],$match);
                foreach ($match[1] as $aurl){
                    $item['content'] = str_replace($aurl,$domain,$item['content']);
                }

                //img标签本地化处理
                preg_match_all('#<img.*?src="([^"]*)"[^>]*>#i',$item['content'], $match);
                foreach($match[1] as $imgurl){
                    $img_url = strpos($imgurl, 'http') !== false ? $imgurl : $domain.$imgurl;
                    $upload = new Uploader($img_url,$config = array(
                        "pathFormat" => "upload/article/{rand:10}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                        "maxSize" => 2048000,
                        "allowFiles" => ['.jpg','.gif','.bmp','.png']
                    ),'remote');
                    $info = $upload->getFileInfo();
                    $content = $item['content'];
                    if($info['state'] == 'SUCCESS'){
                        $content = str_replace($imgurl,'/'.$info['url'],$item['content']);
                    }
                    $item['content'] = $content;
                }

                //详情路径
                $item['url'] = $url;
            }elseif(isset($item['datetime'])){
                preg_match("'\d{4}[/-]\d{1,2}[/-]\d{1,2} (\d{1,2}\:\d{1,2}\:\d{1,2})?'is",trim($item['datetime']),$match);
                $item['datetime'] = isset($match[0]) ? $match[0] : date('Y-m-d H:i:s');
            }elseif (isset($item['click'])){
                preg_match("/\d/",$item['click'],$match);
                $item['click'] = isset($item['click']) ? $match[0] : 0;
            }
            return $item;
        })->getData();

        //采集顺序
        if(isset($options['reverse']) && $options['reverse'] == 'desc'){
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
