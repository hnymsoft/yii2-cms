<?php
namespace system\controllers;

use Yii;
use common\models\Ad;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 广告管理
 * Class AdController
 * @package system\controllers
 */
class AdController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 广告列表
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new \common\models\searchs\Ad();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 广告详情
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 添加广告
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Ad();
        $post_data = Yii::$app->request->post();

        //数据整理
        if(Yii::$app->request->isPost && isset($post_data['Ad']['media_type'])){
            $post_data['Ad']['start_time'] = strtotime($post_data['Ad']['start_time'] . ' 00:00:00');
            $post_data['Ad']['end_time'] = strtotime($post_data['Ad']['end_time'] . ' 23:59:59');

            if($post_data['Ad']['media_type'] == 0){
                $post_data['Ad']['ad_code'] = isset($post_data['Ad']['img_upload']) ? $post_data['Ad']['img_upload'] : $post_data['Ad']['img_link'];
            }elseif ($post_data['Ad']['media_type'] == 1){
                $post_data['Ad']['ad_code'] = isset($post_data['Ad']['font_content']) ? $post_data['Ad']['font_content'] : '';
            }elseif ($post_data['Ad']['media_type'] == 2){
                $post_data['Ad']['ad_code'] = isset($post_data['Ad']['code_content']) ? $post_data['Ad']['code_content'] : '';
            }else{

            }

            if ($model->load($post_data) && $model->save(false)) {
                return $this->redirect(['view', 'id' => $model->ad_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 编辑广告
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post_data = Yii::$app->request->post();

        //数据整理
        if(Yii::$app->request->isPost && isset($post_data['Ad']['media_type'])){
            $post_data['Ad']['start_time'] = strtotime($post_data['Ad']['start_time'] . ' 00:00:00');
            $post_data['Ad']['end_time'] = strtotime($post_data['Ad']['end_time'] . ' 23:59:59');

            if($post_data['Ad']['media_type'] == 0){
                $post_data['Ad']['ad_code'] = isset($post_data['Ad']['img_upload']) ? $post_data['Ad']['img_upload'] : $post_data['Ad']['img_link'];
            }elseif ($post_data['Ad']['media_type'] == 1){
                $post_data['Ad']['ad_code'] = isset($post_data['Ad']['font_content']) ? $post_data['Ad']['font_content'] : '';
            }elseif ($post_data['Ad']['media_type'] == 2){
                $post_data['Ad']['ad_code'] = isset($post_data['Ad']['code_content']) ? $post_data['Ad']['code_content'] : '';
            }else{

            }

            if ($model->load($post_data) && $model->save(false)) {
                return $this->redirect(['view', 'id' => $model->ad_id]);
            }
        }

        switch ($model->media_type){
            case 0:
                if(preg_match("/^http(s)?:\\/\\/.+/",$model->ad_code)){
                    $model->img_link = $model->ad_code;
                }else{
                    $model->img_upload = $model->ad_code;
                }
                break;
            case 1:
                $model->font_content = $model->ad_code;
                break;
            case 2:
                $model->code_content = $model->ad_code;
                break;
            default:
                break;
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 删除广告
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * 模型
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Ad::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
