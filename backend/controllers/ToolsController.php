<?php
namespace backend\controllers;

use common\helpers\Uploader;
use common\models\Setting;
use yii\web\Controller;
use common\models\Config;

class ToolsController extends Controller
{
    /**
     * 文件上传
     * @return string
     */
    public function actionUpload()
    {
        $type = \Yii::$app->request->post('type');
        switch ($type){
            case 'ad':
                $path = "uploads/ad/{rand:10}";
                break;
            case 'avatar':
                $path = "uploads/avatar/{rand:10}";
                break;
            case 'logo':
                $path = "uploads/logo/{rand:10}";
                break;
            case 'flink':
                $path = "uploads/flink/{rand:10}";
                break;
            default:
                $path = "uploads/images/{rand:10}";
                break;
        }

        //读取允许上传大小配置
        $size = 102400;
        if($conf = Setting::getConfInfo('cfg_filesize')){
            $size = $conf->value;
        }

        //读取允许上传格式配置
        $ext = [];
        if($cfg = Setting::getConfInfo('cfg_filetype')){
            $filetype = explode('|',$cfg->value);
            $ext = array_map(function ($v){
                return '.'.$v;
            },$filetype);
        }

        $config = array(
            "pathFormat" => $path, /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "maxSize" => $size,
            "allowFiles" => $ext
        );

        if($_FILES){ //参数配置项图片上传
            $upload = new Uploader('file',$config);
            $info = $upload->getFileInfo();
            if($info['state'] != 'SUCCESS'){
                return ajaxReturnFailure($info['state']);
            }
            return ajaxReturnSuccess('上传成功',$info['url']);
        }else{
            return ajaxReturnFailure('暂无要上传的图片');
        }
    }

    /**
     * 图标
     * @return string
     */
	public function actionIco(){
        $this->layout = '@backend/views/layouts/main-index2';

		return $this->render('ico');
	}
}
