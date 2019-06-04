<?php

//定义时间戳全局变量
defined('GTIME') or define('GTIME', time());

/**
 * 域名函数
 */
if (!function_exists('domain')) {

    function domain() {
        if (YII_ENV_DEV) {
            return \Yii::$app->params['domain']['dev'];
        }
        return \Yii::$app->params['domain']['prod'];
    }

}

/**
 * Openapi接口平台URL
 */
if (!function_exists('openapi')) {

    function openapi() {
        if (YII_ENV == 'prod') {
            return \Yii::$app->params['openapi_url']['prod'];
        }
        return \Yii::$app->params['openapi_url']['dev'];
    }

}

/**
 * 过滤特殊字符串
 */
if (!function_exists('replace_specialChar')) {

    function replace_specialChar($strParam) {
        $regex = "/\～|\，|\。|\！|\？|\“|\”|\【|\】|\『|\』|\：|\；|\《|\》|\’|\‘|\ |\~|\!|\#|\\$|\%|\^|\&|\*|\(|\)|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\;|\'|\`|\=|\|/";
        return preg_replace($regex, "", $strParam);
    }

}

/**
 * sanyibao域名函数
 */
if (!function_exists('sanyibao')) {

    function sanyibao() {
        if (YII_ENV_DEV) {
            return \Yii::$app->params['sanyibao']['dev'];
        }
        return \Yii::$app->params['sanyibao']['prod'];
    }

}

/**
 * URL函数
 */
if (!function_exists('url')) {

    function url($path, $fromUrl = '') {
        if ($fromUrl == '') {
            return \yii\helpers\Url::to($path);
        }
        $prase = parse_url($path);
        $query = [];
        if (array_key_exists('query', $prase)) {
            parse_str($prase['query'], $query);
        }
        if ($fromUrl == 'location') {
            $query['fromUrl'] = urlencode(Yii::$app->request->url);
        } else {
            $query['fromUrl'] = $fromUrl;
        }
        return \yii\helpers\Url::to($prase['path'] . '?' . http_build_query($query));
    }

}

/**
 * 后台 URL函数
 */
if (!function_exists('urlA')) {

    function urlA($path, $fromUrl = '') {
        $path = '/swtmaster' . $path;
        if ($fromUrl == '') {
            return \yii\helpers\Url::to($path);
        }
        $prase = parse_url($path);
        $query = [];
        if (array_key_exists('query', $prase)) {
            parse_str($prase['query'], $query);
        }
        if ($fromUrl == 'location') {
            $query['fromUrl'] = urlencode(Yii::$app->request->url);
        } else {
            $query['fromUrl'] = $fromUrl;
        }
        return \yii\helpers\Url::to($prase['path'] . '?' . http_build_query($query));
    }

}

/**
 * orders
 * @param type $isLevel
 * @return type
 */
function orders($isLevel = false) {
    if ($isLevel) {
        return 'CG' . time();
    }
    return time();
}

if (!function_exists('loadConfig')) {

    function loadConfig($fileName) {
        return require \Yii::getAlias('@common') . '/config/' . $fileName . '.php';
    }

}

if (!function_exists('loadModelObjet')) {

    function loadModelObjet($class) {
        $class_name = '\\common\\models' . '\\' . ucwords($class);
        return new $class_name;
    }

}


if (!function_exists('fromUrl')) {

    function fromUrl($default = '') {
        $fromUrl = Yii::$app->request->get('fromUrl', '');
        if (!$fromUrl) {
            return \yii\helpers\Url::to($default);
        }
        return urldecode($fromUrl);
    }

}

/**
 * 带前缀URL
 */
if (!function_exists('urlp')) {

    function urlp($path = '/') {
        $pre = env('APP_SSL') ? 'https://' : 'http://';
        if ($path == '') {
            return $pre . domain();
        }
        return $pre . domain() . url($path);
    }

}
/**
 * 带前缀URL
 */
if (!function_exists('urlsyb')) {

    function urlsyb($path = '/') {
        $pre = YII_ENV == 'prod' ? 'https://' : 'http://';
        $pre = 'http://';
        if ($path == '') {
            return $pre . sanyibao();
        }
        return $pre . sanyibao() . url($path);
    }

}

/**
 * 成功状态
 */
if (!function_exists('statusSuccess')) {

    function statusSuccess($errmsg = 'success', $data = []) {
        return ajaxStatus(1, $errmsg, $data);
    }

}

/**
 * 状态数组
 */
if (!function_exists('ajaxStatus')) {

    function ajaxStatus($errno = 1, $errmsg = 'success', $data = []) {
        return [
            'status' => $errno,
            'message' => $errmsg,
            'data' => $data
        ];
    }

}

/**
 * 失败数组
 */
if (!function_exists('statusFailure')) {

    function statusFailure($errmsg = 'fail', $data = array()) {
        return ajaxStatus(0, $errmsg, $data);
    }

}


/**
 * 静态资源
 */
if (!function_exists('staticsUrl')) {

    function staticsUrl($path) {
        $path = \Yii::getAlias('@statics') . $path;

        $time = @filemtime("$path");

        $time = $time ? $time : time();

        return urlp($path) . '?v=' . $time;
    }

}

/**
 * dd调试函数
 * @param type $var
 */
if (!function_exists('dd')) {

    function dd($var) {
        if ($var === null) {
            exit('null');
        }
        if (is_bool($var)) {
            if ($var == true) {
                exit('true');
            } else {
                exit('false');
            }
        } else {
            header('Content-Type:text/html;charset=utf-8 ');
            echo '<pre>';
            print_r($var);
            echo '</pre>';
            exit();
        }
    }

}


/**
 * 状态数组
 */
if (!function_exists('ajaxReturn')) {

    function ajaxReturn($status = 1, $message = 'success', $data = []) {
        return json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

}
/**
 * 状态数组
 */
if (!function_exists('nullToDef')) {

    function nullToDef($data = [], $key = '', $defalut = '') {
        return isset($data[$key]) ? $data[$key] : $defalut;
    }

}

/**
 * 成功状态
 */
if (!function_exists('ajaxReturnSuccess')) {

    function ajaxReturnSuccess($errmsg = 'success', $data = []) {
        return ajaxReturn(1, $errmsg, $data);
    }

}

/**
 * 失败数组
 */
if (!function_exists('ajaxReturnFailure')) {

    function ajaxReturnFailure($errmsg = 'failure', $data = array()) {
        return ajaxReturn(0, $errmsg, $data);
    }

}


/**
 * getSession
 */
if (!function_exists('getSession')) {

    function getSession($key) {
        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }
        return $session->has($key) ? $session->get($key) : null;
    }

}

/**
 * 检查手机号
 * @author guost
 */
if (!function_exists('checkphone')) {

    function checkphone($phone) {
        if (!isset($phone) || !preg_match("/^1[3|4|5|6|7|8|9]{1}\d{9}$/", $phone)) {
            return false;
        }
        return true;
    }

}

/**
 * 检查密码
 * @author guost
 */
if (!function_exists('checkpassword')) {

    function checkpassword($password) {
        if (!isset($password) || !preg_match("/^[0-9a-zA-Z]{6,12}$/", $password)) {
            return false;
        }
        return true;
    }

}

/**
 * 检查是否身份证号
 * @author woniu
 */
if (!function_exists('checkIdcard')) {

    function checkIdcard($id) {
        $id = strtoupper($id);
        $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
        $arr_split = array();
        if (!preg_match($regx, $id)) {
            return FALSE;
        }
        if (15 == strlen($id)) { //检查15位
            $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";

            @preg_match($regx, $id, $arr_split);
//检查生日日期是否正确
            $dtm_birth = "19" . $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
            if (!strtotime($dtm_birth)) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {      //检查18位
            $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
            @preg_match($regx, $id, $arr_split);
            $dtm_birth = $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
            if (!strtotime($dtm_birth)) { //检查生日日期是否正确
                return FALSE;
            } else {
//检验18位身份证的校验码是否正确。
//校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                $sign = 0;
                for ($i = 0; $i < 17; $i++) {
                    $b = (int) $id{$i};
                    $w = $arr_int[$i];
                    $sign += $b * $w;
                }
                $n = $sign % 11;
                $val_num = $arr_ch[$n];
                if ($val_num != substr($id, 17, 1)) {
                    return FALSE;
                } else {
                    return TRUE;
                }
            }
        }
    }

}

/**
 * 判断是否来源于手机浏览器
 * @author woniu
 */
if (!function_exists('isMobileClent')) {

    function isMobileClent() {

        $is_mobile = false;

//有些header不存在此变量
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $mobile_agents = Array("240x320", "acer", "acoon", "acs-", "abacho", "ahong", "airness", "alcatel", "amoi", "android", "anywhereyougo.com", "applewebkit/525", "applewebkit/532", "asus", "audio", "au-mic", "avantogo", "becker", "benq", "bilbo", "bird", "blackberry", "blazer", "bleu", "cdm-", "compal", "coolpad", "danger", "dbtel", "dopod", "elaine", "eric", "etouch", "fly ", "fly_", "fly-", "go.web", "goodaccess", "gradiente", "grundig", "haier", "hedy", "hitachi", "htc", "huawei", "hutchison", "inno", "ipad", "ipaq", "ipod", "jbrowser", "kddi", "kgt", "kwc", "lenovo", "lg ", "lg2", "lg3", "lg4", "lg5", "lg7", "lg8", "lg9", "lg-", "lge-", "lge9", "longcos", "maemo", "mercator", "meridian", "micromax", "midp", "mini", "mitsu", "mmm", "mmp", "mobi", "mot-", "moto", "nec-", "netfront", "newgen", "nexian", "nf-browser", "nintendo", "nitro", "nokia", "nook", "novarra", "obigo", "palm", "panasonic", "pantech", "philips", "phone", "pg-", "playstation", "pocket", "pt-", "qc-", "qtek", "rover", "sagem", "sama", "samu", "sanyo", "samsung", "sch-", "scooter", "sec-", "sendo", "sgh-", "sharp", "siemens", "sie-", "softbank", "sony", "spice", "sprint", "spv", "symbian", "tablet", "talkabout", "tcl-", "teleca", "telit", "tianyu", "tim-", "toshiba", "tsm", "up.browser", "utec", "utstar", "verykool", "virgin", "vk-", "voda", "voxtel", "vx", "wap", "wellco", "wig browser", "wii", "windows ce", "wireless", "xda", "xde", "zte");

            foreach ($mobile_agents as $device) {
                if (stristr($user_agent, $device)) {
                    $is_mobile = true;
                    break;
                }
            }
        }

        return $is_mobile;
    }

}

/**
 * 判断是否是微信Client
 * @author woniu
 */
if (!function_exists('isWeixinClent')) {

    function isWeixinClent() {
        $is_mobile = false;

//有些header不存在此变量
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            if (stripos($user_agent, 'micromessenger') && stripos($user_agent, 'wechatdevtools') === false) {
                $is_mobile = true;
            }
        }

        return $is_mobile;
    }

}

/**
 * 判断是否 是https 请求
 */
if (!function_exists("isHttps")) {

    function isHttps() {
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return TRUE;
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return TRUE;
        } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return TRUE;
        }
        return FALSE;
    }

}

/**
 * 检查邮箱
 * @author guost
 */
if (!function_exists('checkemail')) {

    function checkemail($email) {
        $pattern = "/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/";
        if (!preg_match($pattern, $email)) {
            return false;
        }
        return true;
    }

}



/**
 * 获取ip
 * @author:chh
 */
if (!function_exists('getip')) {

    function getip() {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $proxy_ip = explode(',',$_SERVER["HTTP_X_FORWARDED_FOR"]);
            $cip = $proxy_ip[0];
        } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
            $cip = $_SERVER["REMOTE_ADDR"];
        } else {
            $cip = "无法获取！";
        }
        return $cip;
    }

}

/*
 *  生成订单号
 *  @param $pre  前缀 充值：cz;债 提现：tx; 下注：xz ; 打赏 ds ; 借款 jk; 工单 gd;
 *  @param $device 设备 1 web，2 wap，3 android，4 ios 5 空
 *  $id 为 业务id或者 uid
 */
if (!function_exists('createOrderNo')) {

    function createOrderNo($pre, $id, $device = 0) {
        $pre = !empty($pre) ? $pre : 'wz';
        $device = !empty($device) ? $device : '5';
        if (!$id) {
            return false;
        }
        $date = date('ymd'); //6位
        mt_srand((double) microtime() * 1000000);
        $rand = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT); //前补0，6位
        $id = str_pad($id, 6, '0', STR_PAD_LEFT); //前补0，6位
        return strtoupper($pre) . $date . $device . $rand . $id;
    }

}

//将 xml 标签转换成数组
if (!function_exists('xml2Array')) {

    function xml2Array($xml) {

        $objXml = @simplexml_load_string($xml);

        $arrRet = obj2Array($objXml);

        return $arrRet;
    }

}
if (!function_exists('obj2Array')) {

    function obj2Array($objXml) {
        if (!is_object($objXml)) {
            return false;
        }
        if (count($objXml) > 0) {

            $keys = $result = array();

            foreach ($objXml as $key => $val) {
                isset($keys[$key]) ? $keys[$key] += 1 : $keys[$key] = 1;
                if ($keys[$key] == 1) {

                    $result[$key] = obj2Array($val);
                } elseif ($keys[$key] == 2) {

                    $result[$key] = array($result, obj2Array($val));
                } elseif ($keys[$key] > 2) {

                    $result[$key][] = obj2Array($val);
                }
            }

            return $result;
        } else {
            return (string) $objXml;
        }
    }

}

/**
 * 获取指定长度的随机数
 * @param $len
 * model = 1 字符数字，2 数字
 */
if (!function_exists("getRandomStr")) {

    function getRandomStr($len = 16, $model = 1) {
        $str = "";
        if ($model == 2) {
            $str_pol = "0123456789";
        } else {
//$str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
            $str_pol = "ACEFGHJKLMNPRTUVWXY345679acefghjklmnqprtuvwxy";
        }

        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < $len; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }

}

/**
 * 获取参数
 */
if (!function_exists('param')) {

    function param($key = '', $default = '', $methd = 'any') {
        if ($methd == 'get' || $methd == 'GET') {
            return Yii::$app->request->get($key, $default);
        }
        if ($methd == 'post' || $methd == 'POST') {
            return Yii::$app->request->post($key, $default);
        }
        $param = array_merge(Yii::$app->request->get(), Yii::$app->request->post());
        if ($key == '') {
            return $param;
        }
        if (!array_key_exists($key, $param)) {
            return $default ? $default : null;
        }
        return $param[$key];
    }

}

/**
 * 建立请求，以表单HTML形式构造（默认）
 * @param $para 请求参数数组
 * @param $method 提交方式。两个值可选：post、get
 * @param $button_name 确认按钮显示文字
 * @param $type  		返回的类型，form表单，url链接
 * @param $is_auto  		返回form表单时是否自动提交
 * @return 提交表单HTML文本
 */
if (!function_exists('build_request_form')) {

    function build_request_form($url, $para, $method, $button_name = '', $type = 'form', $is_auto = TRUE, $target = '_self') {
        //待请求参数数组
        $sHtml = "<form id='my_auto_submit' name='my_auto_submit' action='" . $url . "' method='" . $method . "' target='{$target}'>";
        $url = trim($url, '?');
        $url .= strpos($url, '?') ? '&' : '?';
        while (list ($key, $val) = each($para)) {
            $sHtml .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
            $url .= "{$key}=" . ($val) . '&';
        }
        $url = trim($url, '&');
        //submit按钮控件请不要含有name属性
        if ($is_auto) {
            $sHtml = $sHtml . "<input type='submit'  value='" . $button_name . "' style='display:none;'></form>";
            $sHtml = $sHtml . "<script>document.forms['my_auto_submit'].submit();</script>";
        } else {
            $sHtml = $sHtml . "<input type='submit'  value='" . $button_name . "'></form>";
        }
        return $type == 'url' ? $url : $sHtml;
    }

}


/**
 * 获取post参数
 */
if (!function_exists('post')) {

    function post($key = '', $default = '') {
        if (!$key) {
            return Yii::$app->request->post();
        }
        $rtn = Yii::$app->request->post($key, $default);
        if (!is_array($rtn)) {
            return trim($rtn);
        }
        return $rtn;
    }

}
/**
 * 获取post参数
 */
if (!function_exists('get')) {

    function get($key = '', $default = '') {
        if (!$key) {
            return Yii::$app->request->get();
        }
        $rtn = Yii::$app->request->get($key, $default);
        if (!is_array($rtn)) {
            return trim($rtn);
        }
        return $rtn;
    }

}

/**
 * 加载环境变量
 * @author df
 */
if (!function_exists('loadEnvConfig')) {

    function loadEnvConfig() {
        $envPath = dirname(dirname(dirname(__FILE__))) . '/.env';
        if (!file_exists($envPath)) {
            return;
        }
        $string = file_get_contents($envPath);
        if (!$string) {
            return;
        }
        $arr = explode("\n", $string);
        if (!count($arr)) {
            return;
        }
        foreach ($arr as $val) {
            if (!$val) {
                continue;
            }
            putenv($val);
        }
    }

}

//直接加载
loadEnvConfig();

/**
 * 读取环境变量
 * @author df
 */
if (!function_exists('env')) {

    function env($key, $default = null) {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        $value = str_replace("\r", "", str_replace("\n", "", $value));
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return;
        }
        return $value;
    }

}

/**
 * 系统菜单
 * @author df
 */
if (!function_exists('systemMenuTitle')) {

    function systemMenuTitle() {
        return Yii::$app->params['system']['menu']['title'];
    }

}

/**
 * 循环创建目录创建目录 递归创建多级目录
 * @param string $dir
 * @param string $mode
 */
function CreateFolder($dir, $mode = 0777) {
    if (is_dir($dir) || @mkdir($dir, $mode))
        return true;
    if (!CreateFolder(dirname($dir), $mode))
        return false;
    return @mkdir($dir, $mode);
}

/**
 * 写日志
 * $file 是 保存的日志名称
 * file = game 或者 game-debug
 * 请勿自定义文件名称
 */
if (!function_exists("writeLog")) {

    function writeLog($log, $file = 'out') {
#生产环境写消息队列
        $dir = Yii::getAlias('@rootPath') . '/out/';
        if (YII_ENV_DEV || 1) {
            CreateFolder($dir);
            $of = @fopen($dir . "{$file}-" . date("Y-m-d-H") . ".txt", 'a+');
            @fwrite($of, $log . "\r\n");
            @fclose($of);
        } else {
            $seaslog = new common\helpers\SeaslogHelper();
            $seaslog::send($file, $log . "\r\n");
        }
    }

}

/**
 *  手机号脱敏
 */
if (!function_exists("hidephone")) {

    function hidephone($phone) {
        if (empty($phone)) {
            return '';
        }
        $phone = substr($phone, 0, 3) . str_repeat("*", 4) . substr($phone, strlen($phone) - 4);
        return $phone;
    }

}

/**
 * 字符串脱敏
 */
if (!function_exists("hide_str")) {

    function hide_str($username) {
        $str_arr = preg_split("//u", $username, -1, PREG_SPLIT_NO_EMPTY);
        if (!preg_match("/[\x7f-\xff]/", $username)) {
            return $cardnum = substr($username, 0, strlen($username) - 3) . str_repeat("*", 3); //用户名
        } else {
            array_pop($str_arr);
            $str = implode("", $str_arr);
            return $str . str_repeat("*", 1);
        }
    }

}

/**
 * 把秒数转换为时分秒的格式
 * @param Int $times 时间，单位 秒
 * @return String
 */
function secToTime($times) {
    $result = [];
    if ($times > 0) {
        $hour = floor($times / 3600);
        $minute = floor(($times - 3600 * $hour) / 60);
        $second = floor((($times - 3600 * $hour) - 60 * $minute) % 60);
        $result = [$hour, $minute, $second];
    }
    return $result;
}

/**
 * 过滤html代码
 */
if (!function_exists('html_clean')) {

    function html_clean($data) {
// Fix &entity\n;
        $data = strip_tags($data);
        $data = str_replace(array(' ', '&nbps;'), '', $data);
        return trim(htmlentities($data));
    }

}

/**
 * 获取当前设备类型
 */
if (!function_exists('getPhoneDevice')) {

    function getPhoneDevice() {

        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '--';
        $type = 2;
        if (strpos($agent, 'iphone') || strpos($agent, 'ipad')) {
            $type = 4;
        }
        if (strpos($agent, 'android')) {
            $type = 3;
        }
        return $type;
    }

}

/**
 * 特殊字符处理
 * @param type $arr
 * @return type
 */
if (!function_exists('strips')) {

    function strips($arr) {
        $data = array();
        if (is_array($arr)) {
            foreach ($arr as $key => $val) {
                if (is_array($val)) {
                    strips($val);
                } else {
                    $arr[$key] = stripcslashes($val);
                }
            }
            $data = $arr;
        } else {
            $data = stripcslashes($arr);
        }
        return $data;
    }

}

/**
 * 公共curl_post方法
 */
if (!function_exists('curlRequest')) {

    function curlRequest($url, $data = null, $header = null) {
        $ch = curl_init();
        try {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (!empty($data)) {
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            if ($header != null) {
                //            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            }
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
            $curlResponse = curl_exec($ch);
            if (!$curlResponse) {
                writeLog("Response:请求超时，返回：" . $curlResponse . "\r\n");
                $status = statusFailure('请求超时');
                $status['error'] = 'QYSYB001';
                return json_encode($status);
            }
        } catch (Exception $e) {
            writeLog("Response:" . $curlResponse . "\r\n");
            $status = statusFailure('请求超时');
            $status['error'] = 'QYSYB002';
            return json_encode($status);
        }
        curl_close($ch);
        return $curlResponse;
    }

}

/**
 * 短信发送或插入队列任务
 * @param number $phone             手机号
 * @param string $template          短信模板配置中的键值
 * @param int    $from_type         来源
 * @param int    $add_ip            ip
 * @param int    $admin_id          管理员id 默认0
 * @param int    $uid               用户id 默认0
 * @param json   $param             短信发送内容集合
 * @param string $doaction          发送类型：send 插入发送队列、received即时发送
 */
if (!function_exists('sendsms_api')) {

    function sendsms_api($phone, $template = '', $param = '', $from_type = 1, $doaction = 'send', $uid = 0, $add_ip = '', $admin_id = 0) {
        if (empty($phone)) {
            return ajaxReturnFailure('手机号不能为空');
        } else if ($template == '') {
            return ajaxReturnFailure('请指定短信模板');
        }
        $url = openapi() . "sendsms/reg";
        $data = array(
            'phone' => $phone,
            'template' => $template,
            'parms' => is_array($param) ? json_encode($param) : '',
            'from_type' => $from_type,
            'doaction' => $doaction,
            'add_ip' => $add_ip ? $add_ip : getIP(),
            'admin_id' => $admin_id,
            'uid' => $uid
        );
        writeLog(date('Y-m-d H:i:s') . '--短信发送签约参数:' . var_export($data, TRUE));
        $res = curlRequest($url, $data);
        writeLog(date('Y-m-d H:i:s') . '--短信返回结果签约参数:' . var_export($res, TRUE));
        return json_decode($res, true);
    }

}

/**
 * AES对称加密
 * modify by yyy
 * mcrypt_encrypt is deleted in PHP7.1
 */
if (!function_exists('api_encrypt')) {

    function api_encrypt($input, $key = '09a7614dba5cd876', $iv = 'dya2nw285ghn3n07') {
        //加密后进行 base64 编码
        //return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $input, MCRYPT_MODE_CBC, $iv));
        return openssl_encrypt($input, "AES-128-CBC", $key, null, $iv); //加密
    }

}

if (!function_exists('api_decrypt')) {

    function api_decrypt($input, $key = '09a7614dba5cd876', $iv = 'dya2nw285ghn3n07') {
        //先进行 base64 解码再解密
//        $result = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($input), MCRYPT_MODE_CBC, $iv);
        //截取解密后的字符串末尾补充的 '\0' 字符
//        return trim($result, "\0");
        return openssl_decrypt($input, "AES-128-CBC", $key, null, $iv); //解密
    }

}


/**
 * 随机图形验证码、短信验证码、注册随机字符串
 * @param int $len
 * @param int $type
 * @return string
 * @author scl
 */
if (!function_exists('randString')) {

    function randString($len = 4, $type = 5) {
        $str = '';
        switch ($type) {
            case 0:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                break;
            case 1:
                $chars = str_repeat('0123456789', 3);
                break;
            case 2:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 3:
                $chars = 'abcdefghijklmnopqrstuvwxyz';
                break;
            default :
// 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
                $chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
                break;
        }
        if ($len > 10) {//位数过长重复字符串一定次数
            $chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
        }
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
        return $str;
    }

}

/*
 *    @param $version1 版本A 如:5.3.2
 *    @param $version2 版本B 如:5.3.0
 *    @return int -1版本A小于版本B , 0版本A等于版本B, 1版本A大于版本B
 *
 *    版本号格式注意：
 *        1.要求只包含:点和大于等于0小于等于2147483646的整数 的组合
 *        2.boole型 true置1，false置0
 *        3.不设位默认补0计算，如：版本号5等于版号5.0.0
 *        4.不包括数字 或 负数 的版本号 ,统一按0处理
 *
 *    @example:
 *       if (versionCompare('5.2.2','5.3.0')<0) {
 *            echo '版本1小于版本2';
 *       }
 */
if (!function_exists('versionCompare')) {

    function versionCompare($versionA, $versionB) {
        if ($versionA > 2147483646 || $versionB > 2147483646) {
            throw new Exception('版本号,位数太大暂不支持!', '101');
        }
        $dm = '.';
        $verListA = explode($dm, (string) $versionA);
        $verListB = explode($dm, (string) $versionB);

        $len = max(count($verListA), count($verListB));
        $i = -1;
        while ($i++ < $len) {
            $verListA[$i] = intval(@$verListA[$i]);
            if ($verListA[$i] < 0) {
                $verListA[$i] = 0;
            }
            $verListB[$i] = intval(@$verListB[$i]);
            if ($verListB[$i] < 0) {
                $verListB[$i] = 0;
            }

            if ($verListA[$i] > $verListB[$i]) {
                return 1;
            } else if ($verListA[$i] < $verListB[$i]) {
                return -1;
            } else if ($i == ($len - 1)) {
                return 0;
            }
        }
    }

}

/**
 * 将ip地址转换为正整型
 */
if (!function_exists('ip2StrLong')) {

    function ip2StrLong($ip) {
        return sprintf("%u", ip2long($ip));
    }

}

/**
 * 将正整型转换为ip地址
 */
if (!function_exists('long2ipStr')) {

    function long2ipStr($data) {
        return long2ip($data);
    }

}

/**
 * null 字符串处理
 */
if (!function_exists('changeNull')) {

    function changeNull(&$string, $tores = '') {
        $string = !is_null($string) ? $string : '';
    }

}

/**
 * 短信类型
 */
if (!function_exists('smsType')) {

    function smsType() {
        return [
            'register' => 'qyRegister', //注册
            'forget' => 'qyForget', //忘记
            'reset' => 'qyReset', //重置
            'bankphone' => 'qyBankphone', //恒丰银行卡预留手机号
        ];
    }

}

/**
 * 反馈类型
 */
if (!function_exists('feedbackType')) {

    function feedbackType() {
        return [
            [
                'name' => "投诉",
                'value' => 1
            ],
            [
                'name' => "建议",
                'value' => 2
            ],
            [
                'name' => "其他",
                'value' => 3
            ]
        ];
    }

}

/**
 * 整合query_string中的重复字段
 * @author yyy
 * @date 2018/08/13
 */
if (!function_exists('mergeQueryString')) {

    function mergeQueryString($params) {
        parse_str($params, $paramsArr);
        $params = http_build_query($paramsArr);
        return $params;
    }

}

/**
 * 将大于一万的金额格式化为万单位 比如130000 = 13万
 * @param type $money 金额
 * @param type $len 小数点后保留位数
 * @param type $status 是否带‘万’字 0 不带 1 带
 * @param type $unit 是否带‘元’，0不带，1带
 * @return string
 */
if (!function_exists('moneyFmt')) {

    function moneyFmt($money, $len = 2, $status = 0, $unit = 0) {
        if ($money >= 10000 && $status) {
            $money = $money / 10000;
            $money = number_format($money, $len, ".", "");
            $money = $money . "万";
        }
        if ($unit) {
            $money = $money . '元';
        }
        return $money;
    }

}

/**
 * 加密传输用的curl
 * @param string $url
 * @param fixed  如果是数组则自动json并加密、尽量传加密后的字符串
 * @return array
 * @author gwg
 * @date 2018-08-30
 */
if (!function_exists('curl_encrypt')) {

    function curl_encrypt($url, $post_data, $key = '09a7614dba5cd876', $iv = 'dya2nw285ghn3n07') {
        $data = is_array($post_data) ? json_encode(['json' => api_encrypt(json_encode($post_data))]) : $post_data; //修改data
        $curl = curl_init($url);
        try {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            if (!empty($data)) {
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data); //$data JSON类型字符串
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
            }

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

            curl_setopt($curl, CURLOPT_TIMEOUT, 60);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
            $curlResponse = curl_exec($curl);
            if (!$curlResponse) {
                writeLog("Response:请求超时，返回：" . $curlResponse . "\r\n");
                $status = statusFailure('请求超时');
                $status['error'] = 'QYSYB001';
                return api_encrypt(json_encode($status));
            }
        } catch (Exception $e) {
            writeLog("Response:" . $curlResponse . "\r\n");
            $status = statusFailure('请求超时');
            $status['error'] = 'QYSYB002';
            return api_encrypt(json_encode($status));
        }
        curl_close($curl);
        return $curlResponse;
    }

}

/**
 * 获取恒丰设备类型
 */
if (!function_exists('getmachinetype')) {

    function getmachinetype($from_type) {
        switch ($from_type) {
            case "1":
                return '01';
            case "02":
                return '02';
            case "3":
            case "11":
                return '11';
            case "4":
            case "12":
                return '12';
            default:
                return '01';
        }
    }

}

/**
 * 对接三益宝，统一担保人格式化输出
 * @param $data array
 *  array(
 *      ['real_name'=> 'XXX', 'idcard'=>'XXX', 'eaccno'=>'XXX'],
 *      ['real_name'=> 'XXX', 'idcard'=>'XXX', 'eaccno'=>'XXX']
 *  );
 * @return string 姓名|身份证号|签章编号,
 *    XXX|XXX|XXX,XXX|XXX|XXX
 * @author yyy
 * @data 2018/09/04
 */
if (!function_exists('suretyFormat')) {

    function suretyFormat($data) {
        $str = '';
        if (is_array($data)) {
            foreach ($data as $k) {
                $str .= implode("|", $k) . ',';
            }
        }
        return rtrim($str, ",");
    }

}

/**
 * 数组去重
 * @author scl
 * @data 2019/01/11
 */
if (!function_exists('arrayToheavy')) {

    function arrayToheavy($data, $type) {
        $result = [];
        if (is_array($data)) {
            foreach ($data as $k => $vo) {
                if (isset($result[$vo[$type]])) {
                    unset($vo[$type]);
                } else {
                    $result[$vo[$type]] = $vo;
                }
            }
        }
        return $result;
    }

}

/**
 * 二维数组去重
 * @param type $array 需要去重的数据
 * @param type $word 根据键值去重的数据
 * @return type $result 去重之后的数据
 */
if (!function_exists('removeDuplicate')) {

    function removeDuplicate($array, $word) {
        $result = [];
        foreach ($array as $value) {
            $has = false;
            foreach ($result as $val) {
                if ($val[$word] == $value[$word]) {
                    $has = true;
                    break;
                }
            }
            if (!$has) {
                $result[] = $value;
            }
        }
        return $result;
    }

}

/**
 * 关键词脱敏
 * @param $cardnum      脱敏字符串
 * @param int $type     脱敏类型
 * @param string $default
 * @return string
 */
if (!function_exists('desensitization')) {

    function desensitization($cardnum, $type = 1, $default = "") {
        if (empty($cardnum))
            return $default;
        if ($type == 1)
            $cardnum = mb_substr($cardnum, 0, 6, 'utf-8') . str_repeat("*", 11) . mb_substr($cardnum, -1, 1, 'utf-8'); //身份证
        elseif ($type == 2)
            $cardnum = mb_substr($cardnum, 0, 3, 'utf-8') . str_repeat("*", 4) . mb_substr($cardnum, -4, 4, 'utf-8'); //手机号
        elseif ($type == 3)
            $cardnum = str_repeat("*", mb_strlen($cardnum, 'utf-8') - 4) . mb_substr($cardnum, -4, 4, 'utf-8'); //银行卡
        elseif ($type == 4)
            $cardnum = mb_substr($cardnum, 0, 3, 'utf-8') . str_repeat("*", mb_strlen($cardnum, 'utf-8') - 3); //用户名
        elseif ($type == 5)
            $cardnum = mb_substr($cardnum, 0, 3, 'utf-8') . str_repeat("*", 3); //用户名
        elseif ($type == 6)
            $cardnum = str_repeat("*", 2) . mb_substr($cardnum, -3, 3, 'utf-8');
        elseif ($type == 7)
            $cardnum = mb_substr($cardnum, 0, 1, 'utf-8') . str_repeat("*", mb_strlen($cardnum, 'utf-8') - 1); //真实姓名
        elseif ($type == 8)
            $cardnum = str_repeat("*", mb_strlen($cardnum, 'utf-8')); //通讯地址
        elseif ($type == 9) {
            if (strpos($cardnum, '@')) {
                $email_array = explode("@", $cardnum);
                $prevfix = (mb_strlen($email_array[0], 'utf-8') < 4) ? "" : mb_substr($cardnum, 0, 3, 'utf-8');
                $count = 0;
                $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $cardnum, -1, $count);
                $cardnum = $prevfix . $str;
            }
        }
        return $cardnum;
    }

}


/**
 * 统一处理字符解密
 * @param type $input
 * @return type
 * @author scl
 * @date 2018-10-24
 */
if (!function_exists('str_decrypt')) {

    function str_decrypt($input = '', $is_encrypt = '') {
        $key = '09a7614dba5cd876';
        $iv = 'dya2nw285ghn3n07';
        switch ($is_encrypt) {
            case 'v1':
                $key = '09a7614dba5cd876';
                $iv = 'dya2nw285ghn3n07';
                break;
            default :
                break;
        }
        $jsoncode = api_decrypt($input, $key, $iv);
        return json_decode(trim($jsoncode), true);
    }

}

/**
 * 格式化时间
 * @param   需要格式的时间  XXXX-XX-XX
 * @param   是否格式化出 开始 或者 结束时间   true 格式化为 XXXX-XX-XX 00:00:00  false 格式化为 XXXX-XX-XX 23:59:59
 */
if (!function_exists('format_datetime')) {

    function format_datetime($date, $is_sdt = true) {
        if (!empty($date)) {
            if ($is_sdt) {
                return strtotime(date('Y-m-d 00:00:00', strtotime($date)));
            } else {
                return strtotime(date('Y-m-d 23:59:59', strtotime($date)));
            }
        }
    }

}

/**
 * 获取params_local数组数据
 */
if (!function_exists('get_params_local')) {

    function get_params_local($key = '', $sub_key = '') {
        if (empty($key) || empty($sub_key)) {
            return '';
        }
        $value = (isset(\Yii::$app->params[$key]) && isset(\Yii::$app->params[$key][$sub_key])) ? \Yii::$app->params[$key][$sub_key] : '';
        return $value;
    }

}
/**
 * 人民币转大写
 * 例如：echo numTrmb(965002.65);
 */
if (!function_exists('numTrmb')) {

    function numTrmb($num) {
        $d = array("零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖");
        $e = array('元', '拾', '佰', '仟', '万', '拾万', '佰万', '仟万', '亿', '拾亿', '佰亿', '仟亿');
        $p = array('分', '角');
        $zheng = "整";
        $final = array();
        $inwan = 0; //是否有万
        $inyi = 0; //是否有亿
        $len = 0; //小数点后的长度
        $y = 0;
        $num = round($num, 2); //精确到分
        if (strlen($num) > 15) {
            return "金额太大";
            die();
        }
        if ($c = strpos($num, '.')) {//有小数点,$c为小数点前有几位
            $len = strlen($num) - strpos($num, '.') - 1; //小数点后有几位数
        } else {//无小数点
            $c = strlen($num);
            $zheng = '整';
        }
        for ($i = 0; $i < $c; $i++) {
            $bit_num = substr($num, $i, 1);
            if ($bit_num != 0 || substr($num, $i + 1, 1) != 0) {
                @$low = $low . $d[$bit_num];
            }
            if ($bit_num || $i == $c - 1) {
                @$low = $low . $e[$c - $i - 1];
            }
        }
        if ($len != 1) {
            for ($j = $len; $j >= 1; $j--) {
                $point_num = substr($num, strlen($num) - $j, 1);
                @$low = $low . $d[$point_num] . $p[$j - 1];
            }
        } else {
            $point_num = substr($num, strlen($num) - $len, 1);
            $low = $low . $d[$point_num] . $p[$len];
        }
        $chinses = str_split($low, 3); //字符串转化为数组
        for ($x = count($chinses) - 1; $x >= 0; $x--) {
            if ($inwan == 0 && $chinses[$x] == $e[4]) {//过滤重复的万
                $final[$y++] = $chinses[$x];
                $inwan = 1;
            }
            if ($inyi == 0 && $chinses[$x] == $e[8]) {//过滤重复的亿
                $final[$y++] = $chinses[$x];
                $inyi = 1;
                $inwan = 0;
            }
            if ($chinses[$x] != $e[4] && $chinses[$x] !== $e[8]) {
                $final[$y++] = $chinses[$x];
            }
        }
        $newstr = (array_reverse($final));
        $nstr = join($newstr);
        if ((substr($num, -2, 1) == '0') && (substr($num, -1) <> 0)) {
            $nstr = substr($nstr, 0, (strlen($nstr) - 6)) . '零' . substr($nstr, -6, 6);
        }
        $nstr = (strpos($nstr, '零角')) ? substr_replace($nstr, "", strpos($nstr, '零角'), 6) : $nstr;
        return $nstr = (substr($nstr, -3, 3) == '元') ? $nstr . $zheng : $nstr;
    }

}

// 获取短信模板
if (!function_exists('getSmsTpl')) {

    function getSmsTpl($key = "") {
        $smsConfig = loadConfig("sms-config");
        $template = $smsConfig['template'];
        if (!$key) {
            return $template;
        }
        if (isset($template[$key])) {
            return $template[$key];
        }
        return [];
    }

}
// 获取发送短息内容
if (!function_exists('getSmsContent')) {

    function getSmsContent($key = "", $parms = []) {
        if (!$key) {
            return false;
        }
        $template = getSmsTpl($key);
        if (!$template) {
            return false;
        }
        if (!$template['parms']) {
            $template['content'] = $template['tpl'];
            return $template;
        }
        $tplParms = $template['parms'];
        $replaceData = explode(',', $tplParms);
        $replaceParam = array();
        foreach ($replaceData as $k => $c) {
            $replaceData[$k] = '${' . $c . '}';
            $replaceParam[$k] = isset($parms[$c]) ? $parms[$c] : '';
        }
        $content = str_replace($replaceData, $replaceParam, $template['tpl']);
        $template['content'] = $content;
        return $template;
    }

}

// 分页输出
if (!function_exists('_list')) {

    function _list($model, $field, $page = 1, $pagesize = 10, $order = 'id desc', $export = 0) {
        $count = $model->count(); //列表数量统计
        $offset = ($page - 1) * $pagesize;
        $model->select($field);
        if (!$export) {
            $model->offset($offset)->limit($pagesize);
        }
        $model = $model->orderBy($order)
            ->asArray()
            ->all();
        return [
            'content' => $model,
            'totalcount' => (isset($count) && intval($count) > 0) ? intval($count) : 0,
            'pagesize' => $pagesize
        ];
    }

}

//长度不够0补齐
if (!function_exists('fillNumber')) {

    function fillNumber($num) {
        $len = strlen($num);
        switch ($len) {
            case 1:
                $no = str_repeat(0, 4) . $num;
                break;
            case 2:
                $no = str_repeat(0, 3) . $num;
                break;
            case 3:
                $no = str_repeat(0, 2) . $num;
                break;
            case 4:
                $no = str_repeat(0, 1) . $num;
                break;
            default:
                $no = $num;
                break;
        }
        return $no;
    }

}
if (!function_exists('removeEmoji')) {

    function removeEmoji($text) {
        $clean_text = "";
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);
        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);
        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);
        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);
        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        return $clean_text;
    }

}

if (!function_exists('userTextEncode')) {

    function userTextEncode($str) {
        if (!is_string($str))
            return $str;
        if (!$str || $str == 'undefined')
            return '';

        $text = json_encode($str); //暴露出unicode
        $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i", function($str) {
            return addslashes($str[0]);
        }, $text); //将emoji的unicode留下，其他不动，这里的正则比原答案增加了d，因为我发现我很多emoji实际上是\ud开头的，反而暂时没发现有\ue开头。
        return json_decode($text);
    }

}
if (!function_exists('userTextDecode')) {

    function userTextDecode($str) {
        $text = json_encode($str); //暴露出unicode
        $text = preg_replace_callback('/\\\\\\\\/i', function($str) {
            return '\\';
        }, $text); //将两条斜杠变成一条，其他不动
        return json_decode($text);
    }

}

//字节数表示更常见的是用KB、MB、GB、TB这些单位表示。
if (!function_exists('trans_byte')) {

    function trans_byte($byte) {
        $KB = 1024;
        $MB = 1024 * $KB;
        $GB = 1024 * $MB;
        $TB = 1024 * $GB;
        if ($byte < $KB) {
            return $byte . "B";
        } elseif ($byte < $MB) {
            return round($byte / $KB, 2) . "KB";
        } elseif ($byte < $GB) {
            return round($byte / $MB, 2) . "MB";
        } elseif ($byte < $TB) {
            return round($byte / $GB, 2) . "GB";
        } else {
            return round($byte / $TB, 2) . "TB";
        }
    }

}

/**
 * 生成32位唯一字符串
 */
if (!function_exists('uniqueStr')) {

    function uniqueStr() {
        return md5(uniqid(microtime(true), true));
    }

}

/**
 * 远程文件下载
 * @param $url
 * @param string $save_dir
 * @param string $filename
 * @param int $type  0 ob_start   1 curl
 * @return array|bool
 */
if (!function_exists('downFileByService')) {
    function downFileByService($url, $save_dir = '', $filename = '', $type = 0)
    {
        if (trim($url) == '') {
            return false;
        }
        //获取远程文件所采用的方法
        if ($type) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $content = curl_exec($ch);
            curl_close($ch);
        } else {
            ob_start();
            readfile($url);
            $content = ob_get_contents();
            ob_end_clean();
        }
        $size = strlen($content);
        $fp2 = @fopen($save_dir . '/' . $filename, 'a');
        fwrite($fp2, $content);
        fclose($fp2);
        unset($content, $url);
        return array(
            'file_name' => $filename,
            'save_path' => $save_dir . '/' . $filename,
            'file_size' => $size
        );
    }
}

/**
 * 循环删除目录和文件函数
 * @param $dirName
 */
if (!function_exists('delDirAndFile')) {
    function delDirAndFile($dirName)
    {
        if ($handle = opendir($dirName)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    if (is_dir($dirName . '/' . $item)) {
                        delDirAndFile($dirName . '/' . $item);
                    } else {
                        if (unlink($dirName . '/' . $item)) echo "成功删除文件： {$dirName}/{$item}";
                    }
                }
            }
            closedir($handle);
            if (rmdir($dirName)) echo "成功删除目录：{$dirName}";
        }
    }
}

/**
 * 创建压ZIP缩包
 * @param $openFile
 * @param $zipObj
 * @param $sourceAbso
 * @param string $newRelat
 */
if (!function_exists('create_zip')) {
    function create_zip($openFile, $zipObj, $sourceAbso, $newRelat = '')
    {
        while (($file = readdir($openFile)) != false) {
            if ($file == "." || $file == "..") {
                continue;
            }
            /*源目录路径(绝对路径)*/
            $sourceTemp = $sourceAbso . '/' . $file;
            /*目标目录路径(相对路径)*/
            $newTemp = $newRelat == '' ? $file : $newRelat . '/' . $file;
            if (is_dir($sourceTemp)) {
                $zipObj->addEmptyDir($newTemp);/*这里注意：php只需传递一个文件夹名称路径即可*/
                $this->createZip(opendir($sourceTemp), $zipObj, $sourceTemp, $newTemp);
            }
            if (is_file($sourceTemp)) {
                writeLog(date('Y-m-d H:i:s').' 合同添加到压缩文件：'.$file);
                $zipObj->addFile($sourceTemp, $newTemp);
            }
        }
    }
}

/**
 * php 数据导出方法
 * @param string $name
 * @param array $data
 * @param array $head
 * @param array $keys
 * @throws \PhpOffice\PhpSpreadsheet\Exception
 * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
 * @author scl
 * @date 2019-01-28
 */
if (!function_exists('phpexplode')) {
    function phpexplode($name = '测试表', $data = [], $head = [], $keys = []) {
        $count = count($head);  //计算表头数量
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        for ($i = 65; $i < $count + 65; $i++) {     //数字转字母从65开始，循环设置表头：
            $sheet->setCellValue(strtoupper(chr($i)) . '1', $head[$i - 65]);
        }
        //开始从数据库提取信息插入Excel表中
        foreach ($data as $key => $item) {             //循环设置单元格：
            //$key+2,因为第一行是表头，所以写到表格时   从第二行开始写

            for ($i = 65; $i < $count + 65; $i++) {     //数字转字母从65开始：
                $sheet->setCellValue(strtoupper(chr($i)) . ($key + 2), $item[$keys[$i - 65]]);
                $spreadsheet->getActiveSheet()->getColumnDimension(strtoupper(chr($i)))->setWidth(20); //固定列宽
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . date('Y-m-d H:i:s') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $result = $writer->save('php://output');
        //删除清空：
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        return $result;
    }
}

/**
 * 移除缓存方法
 * @param $key
 * @return bool
 */
if (!function_exists('flushCache')) {
    function flushCache($key)
    {
        $cache = \Yii::$app->cache->get($key);
        if (!$cache) {
            return false;
        }
        if (\Yii::$app->cache->delete($key)) {
            return true;
        } else {
            return false;
        }
    }
}