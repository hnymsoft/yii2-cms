<?php

namespace system\controllers;

use Yii;
use common\models\Slider;
use common\models\searchs\Slider as SliderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class SliderController
 * @package system\controllers
 */
class SliderController extends Controller
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
     * 列表
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 详情
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
     * 添加
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Slider();
        $model->status = 1;
        $model->order = 0;
        if(Yii::$app->request->isPost){
            $model->create_time = GTIME;
            $model->create_user = Yii::$app->user->identity->username;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 更新
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if(Yii::$app->request->isPost){
            $model->update_time = GTIME;
            $model->update_user = Yii::$app->user->identity->username;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 删除
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()){
            return ajaxReturnSuccess('删除成功');
        }else{
            return ajaxReturnFailure('删除失败');
        }
    }

    /**
     * 状态编辑
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAjaxstatus($id){
        $status = Yii::$app->request->post();
        if($status && in_array($status,[0,1])){
            return ajaxReturnFailure('参数错误');
        }
        $model = $this->findModel($id);
        if($model->load($status,'') && $model->save(false)){
            return ajaxReturnSuccess('状态编辑成功');
        }
        return ajaxReturnFailure('状态编辑失败');
    }

    /**
     * 模型
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
