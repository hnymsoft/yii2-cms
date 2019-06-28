<?php
namespace common\models;

use common\helpers\Uploader;
use QL\Ext\AbsoluteUrl;
use QL\Ext\CurlMulti;
use QL\QueryList;
use yii\base\Model;

/**
 * 采集基类
 * Class Collection
 * @package common\models
 */
class Collection extends Model
{
    //采集实例
    private $_query;
    private $_encode = 'utf-8';

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
     * 配置信息
     * @return mixed
     */
    public function getConf(){
        $conf['url'] = 'http://www.dedecms.com/knowledge/web-based/div-css/';
        $conf['options'] = [
            'head' => 1, //0 不移除 1 移除
            'encode' => 'gb2312',      //utf-8、gb2312、gbk
            'reverse' => 'desc',   //asc升序   desc降序
            'referer' => 'http://www.dedecms.com', //引用地址
            'replace_url' => 'http://www.aimitech.com'
        ];
        $conf['list'] = [
            'range' => '.arc_list ul',
            'rules' => [
                'title' => ['a','text'],
                'url' => ['a','href'],
                'thumb' => ['img','src']
            ]
        ];
        $conf['content'] = [
            'range' => '',
            'rules' => [
                'title' => ['.arcbody h1','text'],
                'kw' => ['meta[name=keywords]','content'],
                'desc' => ['meta[name=description]','content'],
                'content' => ['.content','html','-#contentMidPicAD'],
//                'author' => ['','text'],
//                'click' => ['','text'],
//                'source' => ['','text'],
//                'datetime' => ['','text']
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
        //$args['timeout'] = 30;
        $args['headers'] = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36',
            'Referer' => ''
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
                    $url = parse_url($url);
                    $domain = "{$url['scheme']}://{$url['host']}";
                    //相对链接改为绝对链接
                    if(isset($item['url']) && !preg_match("/^(http:\/\/|https:\/\/).*$/",$item['url'])){
                        $item['url'] = "{$domain}{$item['url']}";
                    }
                    if(isset($item['content'])){
                        //a标签外部链接替换
                        preg_match_all('/<a .*?href="(.*?)".*?>/is',$item['content'],$match);
                        foreach ($match[1] as $aurl){
                            $item['content'] = str_replace($aurl,$options['replace_url'],$item['content']);
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
                            if($info['state'] == 'SUCCESS'){
                                $content = str_replace($imgurl,'/'.$info['url'],$item['content']);
                            }
                            $item['content'] = $content;
                        }
                    }
                    return $item;
                })->getData();

        //采集顺序
        if(isset($options['reverse']) && $options['reverse'] == 'desc'){
            $result->reverse();
        }
        return $result->all();
    }

    /**
     * 采集数据（多线程）
     */
    public function getMultiCollectionData(){

    }
}