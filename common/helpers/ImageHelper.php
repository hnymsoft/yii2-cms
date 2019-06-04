<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\helpers;

use Yii;
use OSS\OssClient;
use DateTime;
use Sts\Request\V20150401\AssumeRoleRequest;

/**
 * Description of FileHelper
 * 图片文件操作类
 * @author hhs
 * @date 2018-7-12
 */
class ImageHelper {

    private $accesskeyid;
    private $accesskeysecret;
    private $endpoint;
    private $alibucket;
    private $rolearn;
    private $tokenexpiretime;
    private $policyfile;
    private $oss;

    public function __construct() {
        $get_config = loadConfig('alioss');
        $config = $get_config[env("DEVELOPMENT") == 'prod' ? 'prod' : 'test'];
        $this->accesskeyid = isset($config['accessKeyId']) ? $config['accessKeyId'] : $this->accesskeyid;
        $this->accesskeysecret = isset($config['accessKeySecret']) ? $config['accessKeySecret'] : $this->accesskeysecret;
        $this->endpoint = isset($config['endPoint']) ? $config['endPoint'] : $this->endpoint;
        $this->alibucket = isset($config['aliBucket']) ? $config['aliBucket'] : $this->alibucket;
        $this->rolearn = isset($config['roleArn']) ? $config['roleArn'] : $this->rolearn;
        $this->tokenexpiretime = isset($config['tokenExpireTime']) ? $config['tokenExpireTime'] : $this->tokenexpiretime;
        $this->policyfile = isset($config['policyFile']) ? $config['policyFile'] : $this->policyfile;
        $this->oss = new OssClient($this->accesskeyid, $this->accesskeysecret, $this->endpoint);
    }

    /**
     * 阿里云文件本地上传
     * @author hhs
     * @param type $filename     本地存放路径
     * @param type $savefilename oss保存路径
     * @return type  返回上传成功的图片url
     */
    public function alioss_upload($filename = null, $savefilename = null) {
        if (!file_exists($filename)) {
            return null;
        }
        $result = $this->oss->uploadFile($this->alibucket, $savefilename, $filename);
        if (!empty($result)) {
            return $result['info']['url'];
        }
        return null;
    }

    /**
     * 阿里云文件表单上传
     * @param type $file  $_FILES文件
     * @param type $filepath 上传的路径
     * @return string
     */
    public function putObject($file = null, $filepath = null) {
        if (empty($file) || empty($filepath)) {
            return '';
        }
        $content = file_get_contents($file['tmp_name']); // 把当前文件的内容获取到传入文件中
        $suffix = explode('.', $file['name'])[1];
        $date = date("Y") . date("m") . date("d");
        $file_path = $filepath . '/' . $date . '/' . getRandomStr(8, 1) . '.' . $suffix;
        $options = array();
        try {
            $this->oss->putObject($this->alibucket, $file_path, $content, $options);
        } catch (OssException $e) {
            return '';
        }
        return $file_path;
    }

    /**
     * 删除阿里云oss上的图片
     * @param type $object 待删除的对象
     * @return boolean
     */
    public function alioss_delete($object) {
        $res = $this->oss->deleteObject($this->alibucket, $object);
        if ($res) {
            return true;
        }
        return false;
    }

    public function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration . "Z";
    }

    /**
     * 生成阿里云表单上传所需要的签名等信息
     * @author hhs
     * @date 2018-7-13
     * @return string
     */
    public function get_upload_authparam($filepath = 'image', $filename = '') {
        $key = $this->accesskeysecret;
        $host = 'http://' . $this->alibucket . '.' . $this->endpoint;
        /* $callbackUrl = "http://contract.sanyibao.com:82/api/file/hhstest";
          $callback_param = array('callbackUrl' => $callbackUrl,
          'callbackBody' => 'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}',
          'callbackBodyType' => "application/x-www-form-urlencoded");
          $callback_string = json_encode($callback_param);
          $base64_callback_body = base64_encode($callback_string); */
        $now = time();
        $expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = $this->gmt_iso8601($end);
        $dir = $filepath . '/' . $filename;
        //最大文件大小.用户可以自己设置
        $condition = array(0 => 'content-length-range', 1 => 0, 2 => 1048576000);
        $conditions[] = $condition;
        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0 => 'starts-with', 1 => '$key', 2 => $dir);
        $conditions[] = $start;
        $arr = array('expiration' => $expiration, 'conditions' => $conditions);
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response = array();
        $response['accessid'] = $this->accesskeyid;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        //$response['callback'] = $base64_callback_body;//回调函数
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        return $response;
    }

    /**
     * app获取oss授权token
     * 用户app sdk上传
     * @return type
     */
    public function aliOssRamtoken() {

        $file_path = Yii::getAlias("@vendor") . '/aliyuncs/sts-server/';
        include_once $file_path . 'aliyun-php-sdk-core/Config.php';
        include_once $file_path . 'aliyun-php-sdk-core/Profile/DefaultProfile.php';
        include_once $file_path . 'aliyun-php-sdk-core/DefaultAcsClient.php';
        $accessKeyID = $this->accesskeyid;
        $accessKeySecret = $this->accesskeysecret;
        $roleArn = $this->rolearn;
        $tokenExpire = $this->tokenexpiretime;

        $policy = $this->read_file($file_path . $this->policyfile);
        $iClientProfile = \DefaultProfile::getProfile("cn-hangzhou", $accessKeyID, $accessKeySecret);
        $client = new \DefaultAcsClient($iClientProfile);
        $request = new AssumeRoleRequest();
        $request->setRoleSessionName("client_name");
        $request->setRoleArn($roleArn);
        $request->setPolicy($policy);
        $request->setDurationSeconds($tokenExpire);
        $response = $client->doAction($request);
        $rows = array();
        $body = $response->getBody();
        $content = json_decode($body);
        if ($response->getStatus() == 200) {
            $rows['StatusCode'] = 200;
            $rows['AccessKeyId'] = $content->Credentials->AccessKeyId;
            $rows['AccessKeySecret'] = $content->Credentials->AccessKeySecret;
            $rows['Expiration'] = $content->Credentials->Expiration;
            $rows['SecurityToken'] = $content->Credentials->SecurityToken;
        } else {
            $rows['StatusCode'] = 500;
            $rows['ErrorCode'] = $content->Code;
            $rows['ErrorMessage'] = $content->Message;
        }
        echo json_encode($rows);
        return;
    }

    function read_file($fname) {
        $content = '';
        if (!file_exists($fname)) {
            echo "The file $fname does not exist\n";
            exit(0);
        }
        $handle = fopen($fname, "rb");
        while (!feof($handle)) {
            $content .= fread($handle, 10000);
        }
        fclose($handle);
        return $content;
    }

}
