<?php
namespace system\controllers;

use common\models\DataBase;
use Yii;
use backend\controllers\BaseController;
use system\Module;
use yii\data\ArrayDataProvider;

/**
 * 导出数据库
 * Class ExportController
 * @package system\controllers
 */
class ExportController extends BaseController
{
    private $_db;
    public function __construct($id, Module $module, array $config = [])
    {
        $this->_db = Yii::$app->db;
        parent::__construct($id, $module, $config);
    }

    /**
     * 列表
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex(){
        $model = $this->_db->createCommand('SHOW TABLE STATUS')->queryAll();
        $table = array_map('array_change_key_case', $model);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $table
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 优化表
     * @param string $tables
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionOptimize($tables = ''){
        if(!$tables){
            return ajaxReturnFailure('请选择要优化的数据表');
        }
        $res = $this->_db->createCommand("OPTIMIZE TABLE `{$tables}`")->execute();
        if($res){
            return ajaxReturnSuccess("数据表'{$tables}'优化完成！");
        }else{
            return ajaxReturnFailure("数据表'{$tables}'优化出错请重试！");
        }
    }

    /**
     * 修复
     * @param string $tables
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionRepair($tables = ''){
        if(!$tables){
            return ajaxReturnFailure('请选择要修复的数据表');
        }
        $res = $this->_db->createCommand("REPAIR TABLE `{$tables}`")->execute();
        if($res){
            return ajaxReturnSuccess("数据表'{$tables}'修复完成！");
        }else{
            return ajaxReturnFailure("数据表'{$tables}'修复出错请重试！");
        }
    }

    /**
     * 数据表备份
     * @return string
     */
    public function actionBackup(){
        $tables = \Yii::$app->request->post('table');
        if(!$tables || !is_array($tables)){
            return ajaxReturnFailure('请选择要备份的数据表');
        }
        $path = \Yii::$app->params['DATA_BACKUP']['PATH'];
        if(!is_dir($path)){
            @mkdir($path, 0755, true);
        }
        //检查是否有正在执行的任务
        $lock = "{$path}/backup.lock";
        if(!is_file($lock)){
            file_put_contents($lock,time());
        } else {
            return ajaxReturnFailure('检测到有任务正在执行，请稍后再试！');
        }
        $backup = new DataBase([
            'name' => date('Ymd-His',time()),
            'part' => 1,
        ],[
            'path' => $path . DIRECTORY_SEPARATOR,
            'part' => Yii::$app->params['DATA_BACKUP']['PART_SIZE'],
            'compress' => Yii::$app->params['DATA_BACKUP']['COMPRESS'],
            'level' => Yii::$app->params['DATA_BACKUP']['COMPRESS_LEVEL']
        ]);
        if($backup->create() === false){
            return ajaxReturnFailure('初始化失败，备份文件创建失败！');
        }else{
            return $this->dataBackup($backup,$tables,0,0);
        }
    }

    /**
     * 数据备份
     * @param $objBackup
     * @param $tables
     * @param int $index
     * @param int $offset
     * @return string
     */
    public function dataBackup($objBackup,$tables,$index = 0,$offset = 0){
        if(!empty($tables[$index])){
            $start  = $objBackup->backup($tables[$index],$offset);
            if($start === false){
                return ajaxReturnFailure('数据表备份失败！');
            }elseif ($start === 0){ //备份下一张表
                $index++;
                return $this->dataBackup($objBackup,$tables,$index,0);
            }else{
                return $this->dataBackup($objBackup,$tables,$index,$start[0]);
            }
        }else{
            @unlink(\Yii::$app->params['DATA_BACKUP']['PATH'].DIRECTORY_SEPARATOR."backup.lock");
            return ajaxReturnSuccess('数据表备份完成，共备份（'.count($tables).'）张表！');
        }
    }
}