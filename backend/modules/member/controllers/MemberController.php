<?php

namespace member\controllers;

use Yii;
use common\models\Member;
use common\models\searchs\Member as MemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class MemberController
 * @package member\controllers
 */
class MemberController extends Controller
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
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MemberSearch();
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
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Member();
        $model->status = 10;
        $model->scenario = 'create';
        $postData = Yii::$app->request->post();
        if(Yii::$app->request->isPost && isset($postData)){
            $postData['Member']['password_hash'] = Yii::$app->security->generatePasswordHash($postData['Member']['password_hash']);
            $postData['Member']['auth_key'] = Yii::$app->security->generateRandomString();
            $model->generatePasswordResetToken();
        }
        if ($model->load($postData) && $model->save(false)) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 编辑
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $postData = Yii::$app->request->post();

        if ($model->load($postData) && $model->validate()) {
            unset($model->password_hash);
            if($postData['Member']['password_hash']){
                $model->password_hash = Yii::$app->security->generatePasswordHash($postData['Member']['password_hash']);
            }
            $model->password_reset_token = null;
            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 删除
     * @param $id
     * @return string
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
        if($status && in_array($status,[0,10])){
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
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
