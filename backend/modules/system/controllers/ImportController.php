<?php
namespace system\controllers;

use Yii;
use backend\controllers\BaseController;
use common\models\DataBase;
use yii\data\ArrayDataProvider;

/**
 * 导入数据库
 * Class ImportController
 * @package system\controllers
 */
class ImportController extends BaseController
{
    /**
     * 列表
     * @return string
     */
    public function actionIndex(){
        $path = \Yii::$app->params['DATA_BACKUP']['PATH'];
        if(!is_dir($path)){
            @mkdir($path, 0755, true);
        }
        $path = realpath($path);
        $fileSystem = new \FilesystemIterator($path, \FilesystemIterator::KEY_AS_FILENAME);
        $list = array();
        foreach ($fileSystem as $name => $file) {
            if(preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)){
                $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');
                $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                $part = $name[6];
                if(isset($list["{$date} {$time}"])){
                    $info = $list["{$date} {$time}"];
                    $info['part'] = max($info['part'], $part);
                    $info['size'] = $info['size'] + $file->getSize();
                } else {
                    $info['part'] = $part;
                    $info['size'] = $file->getSize();
                }
                $extension        = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                $info['time']     = strtotime("{$date} {$time}");

                $list["{$date} {$time}"] = $info;
            }
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $list
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 还原
     * @param int $time
     * @return string
     */
    public function actionRestore($time = 1560411243){
        $name  = date('Ymd-His', $time) . '-*.sql*';
        $path  = \Yii::$app->params['DATA_BACKUP']['PATH'] . DIRECTORY_SEPARATOR . $name;
        $files = glob($path);
        $list  = array();
        foreach($files as $name){
            $basename = basename($name);
            $match    = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
            $gz       = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
            $list[$match[6]] = array($match[6], $name, $gz);
        }
        ksort($list);

        $last = end($list);
        if(count($list) !== $last[0]){
            return ajaxReturnFailure('备份文件可能已经损坏，请检查！');
        }else{
            $restore = new DataBase($list[1],[
                'path' => $path . DIRECTORY_SEPARATOR,
                'compress' => $list[1][2],
            ]);
            return $this->dataRestore($restore,$list,1,0);
        }
    }

    /**
     * 数据还原
     * @param $objRestore
     * @param $part
     * @param int $offset
     * @return string
     */
    public function dataRestore($objRestore,$tables,$part,$offset = 0){
        if(!empty($tables[$part])){
            $start  = $objRestore->import($offset);
            if($start === false){
                return ajaxReturnFailure('数据表还原失败！');
            }elseif ($start === 0){ //备份下一卷
                ++$part;
                return $this->dataRestore($objRestore,$tables,$part,$offset);
            }else{
                return $this->dataRestore($objRestore,$tables,$part,$start[0]);
            }
        }else{
            return ajaxReturnSuccess('数据表还原完成！');
        }
    }

    /**
     * 删除
     * @param string $time
     * @return string
     */
    public function actionDelete($time = ''){
        if(!$time){
            return ajaxReturnFailure('参数错误');
        }
        $name  = date('Ymd-His', $time) . '-*.sql*';
        $path  = \Yii::$app->params['DATA_BACKUP']['PATH'] . DIRECTORY_SEPARATOR . $name;
        array_map("unlink", glob($path));
        if(count(glob($path))){
            return ajaxReturnFailure('备份文件删除失败，请检查权限!');
        } else {
            return ajaxReturnSuccess('备份文件删除成功');
        }
    }
}