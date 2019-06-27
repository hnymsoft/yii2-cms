<?php

namespace system\controllers;

use backend\controllers\BaseController;
use common\models\BaseModel;
use common\models\Channel;
use Yii;
use common\models\Module;
use common\models\searchs\Module as ModuleSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ModuleController implements the CRUD actions for Module model.
 */
class ModuleController extends BaseController
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
        $searchModel = new ModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
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
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new Module();
        $model->status = 1;

        if(Yii::$app->request->isPost){
            $transaction = Yii::$app->db->beginTransaction();
            $model->create_user = Yii::$app->user->identity->username;
            $model->create_addtime = GTIME;
            if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
                //创建附加表
                $model->createModelsTable($model->attach_table);
                $transaction->commit();
                return $this->redirect(['index']);
            }else{
                $transaction->rollBack();
            }
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
            $model->update_user = Yii::$app->user->identity->username;
            $model->update_addtime = GTIME;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
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
        $count = Channel::find()->where(['m_id'=>$id])->count();
        if($count){
            return ajaxReturnFailure('当前模型栏目不为空，删除失败！');
        }
        $transaction = Yii::$app->db->beginTransaction();
        $model = $this->findModel($id);
        if($model && $model->delete()){
            //删除附加表
            $res = $model->dropModelsTable($model->attach_table);
            if(!$res['status']){
                return ajaxReturnSuccess($res['message']);
            }
            $transaction->commit();
            return ajaxReturnSuccess('删除成功');
        }

        $transaction->rollBack();
        return ajaxReturnFailure('删除失败');
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
        if (($model = Module::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCheckTableUnique($id = null){
        $model = new Module();
        $model->load(Yii::$app->request->post());
        return json_encode(\yii\widgets\ActiveForm::validate($model,'attach_table'));
    }
}
