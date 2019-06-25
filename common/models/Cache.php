<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Class Cache
 * @package common\models
 */
class Cache extends Model
{
    /**
     * 清空所有schema缓存
     */
    public static function flushSchema(){
        Yii::$app->db->schema->refresh();
        return true;
    }

    /**
     * 清空全站缓存
     * @return bool
     */
    public static function flushAll(){
        //更新当前模块缓存
        $res = Yii::$app->cache->flush();

        //跨模块删除只需删除前台即可
        $path = Yii::getAlias('@frontend/runtime/cache/');
        $res_cache = static::delCacheDir($path);
        $path = Yii::getAlias('@frontend/runtime/logs/');
        $res_logs = static::delCacheDir($path);
        if($res && $res_cache && $res_logs){
            return ajaxReturnSuccess('更新成功');
        }else{
            return ajaxReturnFailure('更新失败');
        }
    }

    /**
     * 更新缓存目录
     * @param $path
     * @return string
     */
    public static function delCacheDir($path){
        if(delDirAndFile($path)){
            return ajaxReturnSuccess('更新成功');
        }else{
            return ajaxReturnFailure('更新失败');
        }
    }

    /**
     * 清空系统缓存
     * @param $type
     * @return bool|void
     */
    public static function run($type){
        if(!in_array($type,['f_cache','f_redis','f_logs','b_cache','b_logs','schema','all'])){
            return ajaxReturnFailure('参数错误！');
        }
        if($type == 'f_cache'){
            $path = Yii::getAlias('@frontend/runtime/cache/');
            $res = static::delCacheDir($path);
        }elseif ($type == 'f_redis'){
            $path = Yii::getAlias('@frontend/runtime/cache/');
            $res = static::delCacheDir($path);
        }elseif ($type == 'f_logs'){
            $path = Yii::getAlias('@frontend/runtime/logs/');
            $res = static::delCacheDir($path);
        }elseif ($type == 'b_cache'){
            $path = Yii::getAlias('@backend/runtime/cache/');
            $res = static::delCacheDir($path);
        }elseif ($type == 'b_logs'){
            $path = Yii::getAlias('@backend/runtime/logs/');
            $res = static::delCacheDir($path);
        }elseif ($type == 'schema'){
            $res = static::flushSchema();
        }elseif ($type == 'all'){
            $res = static::flushAll();
        }
        return $res;
    }
}
