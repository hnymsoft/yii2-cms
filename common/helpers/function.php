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
 * 过滤特殊字符串
 */
if (!function_exists('replace_specialChar')) {

    function replace_specialChar($strParam) {
        $regex = "/\～|\，|\。|\！|\？|\“|\”|\【|\】|\『|\』|\：|\；|\《|\》|\’|\‘|\ |\~|\!|\#|\\$|\%|\^|\&|\*|\(|\)|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\;|\'|\`|\=|\|/";
        return preg_replace($regex, "", $strParam);
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
 * 数组去重
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
    function delDirAndFile($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }
        $handle = opendir($dir);
        while (($file = readdir($handle)) !== false) {
            if ($file != "." && $file != "..") {
                is_dir("$dir/$file") ? delDirAndFile("$dir/$file") : @unlink("$dir/$file");
            }
        }
        if (readdir($handle) == false) {
            closedir($handle);
            @rmdir($dir);
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
                $zipObj->addFile($sourceTemp, $newTemp);
            }
        }
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