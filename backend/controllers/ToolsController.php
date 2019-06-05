<?php
namespace backend\controllers;

use common\helpers\Uploader;
use yii\web\Controller;
use common\models\Config;

class ToolsController extends Controller
{
	/**
	 * 富文本编辑器上传文件
	 */
    public function actionUploadEditor()
    {
        $file = $_FILES;
        $file_name = $file['wangEditorH5File']['name'];
        $file_tmp_path =$file['wangEditorH5File']['tmp_name'];
        $dir = "../../uploads/".date("Ymd");
        if (!is_dir($dir)){
            mkdir($dir,0777);
        }
		$type = substr(strrchr($file_name, '.'), 1);
		$mo = Config::findOne(['name'=>'WEB_SITE_ALLOW_UPLOAD_TYPE']);
		$allow_type = explode(',', $mo->value);
		if(!in_array($type, $allow_type)){
			die("文件类型为允许的格式");
		}
        $file_save_name = date("YmdHis",time()) . mt_rand(1000, 9999) . '.' . $type;
        move_uploaded_file($file_tmp_path, $dir.'/'.$file_save_name);
        echo Config::findOne(['name'=>'WEB_SITE_RESOURCES_URL'])->value . date('Ymd').'/'.$file_save_name;
    }

    /**
     * 图片上传
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
            default:
                $path = "uploads/images/{rand:10}";
                break;
        }
        $config = array(
            "pathFormat" => $path, /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "maxSize" => 5120000 * 4, /* 20M 上传大小限制，单位B */
            "allowFiles" => [".jpg",".jpeg",".png",".bmp",".gif"] /* 上传图片格式显示 */
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
