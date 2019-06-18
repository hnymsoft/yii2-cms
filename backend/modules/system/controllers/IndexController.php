<?php

namespace system\controllers;

use backend\controllers\BaseController;

/**
 * Class IndexController
 * @package system\controllers
 */
class IndexController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionWelcome()
    {
        $system_info = [
            'os' => PHP_OS,
            'ip' => $_SERVER['SERVER_ADDR'],
            'web_server' => $_SERVER['SERVER_SOFTWARE'],
            'php_ver' => PHP_VERSION,
            'mysql_ver' => \Yii::$app->db->getServerVersion(),
            'zlib' => function_exists('gzclose') ? 'Yes' : 'No',
            'safe_mode' => (boolean) ini_get('safe_mode') ? 'Yes' : 'No',
            'safe_mode_gid' => (boolean) ini_get('safe_mode_gid') ? 'Yes' : 'No',
            'time_zone' => function_exists("date_default_timezone_get")?date_default_timezone_get():'no_timezone',
            'socket' => function_exists('fsockopen') ? 'Yes' : 'No',
            'gd' => function_exists('gd_info') ? 'Yes' : 'No',
            'max_filesize' => ini_get('upload_max_filesize')
        ];
        return $this->render('welcome',[
            'sysinfo' => $system_info
        ]);
    }
}
