<?php

namespace common\helpers;

use yii\base\Component;
use JPush\Client as JPush;
use JPush\Config;

/**
 * 三益宝手机端推送
 * @author gzh
 */
class Sybpush extends Component {

    public $jPush;
    public $push;
    public $appKey = '';
    public $masterSecret = '';
    public $message = '';
    public $platForm = array("all", 'ios', 'android');
    private static $LIMIT_KEYS = array('X-Rate-Limit-Limit' => 'rateLimitLimit', 'X-Rate-Limit-Remaining' => 'rateLimitRemaining', 'X-Rate-Limit-Reset' => 'rateLimitReset');
    private $device;

    public function init() {

        $jpush = loadConfig('jpush');
        $this->appKey = trim($jpush['appKey']);
        $this->masterSecret = trim($jpush['masterSecret']);

        $this->jPush = new JPush($this->appKey, $this->masterSecret);
        $this->push = $this->jPush->push();
        $this->device = $this->jPush->device();
    }

    /**
     * 设置平台信息
     * @param type $platForm 
     * @param type $message 发送信息
     * @param type $extras 扩展字段
     */
    private function setPlatform($platForm, $title, $message, $extras) {
        if ($platForm == "all") {
            $plats = array('ios', 'android');
        } else {
            $plats = array($platForm);
        }
        $this->push->setPlatform($plats);
        foreach ($plats as $v) {
            if ($v == 'ios') {
                $this->push->addIosNotification($message, 'iOS sound', Config::DISABLE_BADGE, true, 'iOS category', $extras);
                continue;
            }
            if ($v == 'android') {
                $this->push->addAndroidNotification($message, $title, 1, $extras);
                continue;
            }
        }
    }

    /**
     * 发送信息至极光平台
     * @param array $data
     * message string 发送主体内容
     * alias string|array 接收人手机号 可以是字符串也可以是数组 如果是字符串的话 需要用竖线（|）分割
     * platForm  string  all| android | ios  如果全退则用all 
     * title string 推送标题 
     * @return type
     * @throws Exception
     */
    public function send($data = array()) {
        if (!$data) {
            throw new \Exception("参数不能为空");
        }

        if (!$data['message']) {
            throw new \Exception("发送消息不能为空");
        }
        $message = $data['message'];

        if (isset($data['platForm']) && in_array($data['platForm'], $this->platForm)) {
            $platForm = $data['platForm'];
        } else {
            $platForm = "all";
        }
        if (isset($data['audience']) && $data['audience'] == 'all') {
            $audience = 'all';
        }else{
            $audience = 'mobile';
        }
        if (isset($data['title']) && !empty($data['title'])) {
            $title = $data['title'];
        } else {
            $title = "三益宝借款端提示信息：";
        }
        $extras = $data['extras'];
        if (!array_key_exists("msg_type", $extras)) {
            throw new \Exception("抛送类型不能为空");
        }
        $this->setPlatform($platForm, $title, $message, $extras);
        //全部推送
        if($audience == 'all'){
            $this->push->addAllAudience();
        }else{
            if (!$data['tag']) {
                throw new \Exception("发送手机号不能为空");
            }
            $tag = $data['tag'];
            if (is_array($tag)) {
                $tag_phone = $tag;
            } else {
                $tag_phone = explode("|", $tag);
            }
            if (!$tag_phone) {
                return false;
            }
            $this->push->addTag($tag_phone);
        }
        //IOS推送环境：true 正式  false 测试
        $env_type = env('DEVELOPMENT') === 'test' ? false : true;
        $this->push->setOptions(100000, 3600, null,$env_type);
        $res = $this->push->send();
        return $this->__processResp($res);
    }

    /**
     * 格式化数据 为跟三益宝平台保持一致
     * @param type $response
     * @return type
     * @throws APIRequestException
     */
    private function __processResp($response) {

        if ($response['http_code'] === 200) {
            $body = array();
            $body['data'] = $response['body'];
            $headers = $response['headers'];
            if (is_array($headers)) {
                $limit = array();
                foreach (self::$LIMIT_KEYS as $key => $value) {
                    if (array_key_exists($key, $headers)) {
                        $limit[$value] = $headers[$key];
                    }
                }
                if (count($limit) > 0) {
                    $body['limit'] = (object) $limit;
                }
                return (object) $body;
            }
            return $body;
        } else {
            return [];
//            throw new \JPush\Exceptions\APIRequestException($response);
        }
    }

}
