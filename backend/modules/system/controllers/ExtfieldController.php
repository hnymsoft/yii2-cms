<?php

namespace system\controllers;

use backend\controllers\BaseController;
use Yii;
use common\models\ExtField;
use common\models\searchs\ExtField as ExtFieldSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExtfieldController implements the CRUD actions for ExtField model.
 */
class ExtfieldController extends BaseController
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
        $searchModel = new ExtFieldSearch();
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
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new ExtField();
        if(Yii::$app->request->isPost){
            $transaction = Yii::$app->db->beginTransaction();
            if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
                //处理自定义字段
                $model->setAttachTableField($model->modules->attach_table,$model->item,$model->value,$model->f_type,1);
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

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            //处理自定义字段
            $model->setAttachTableField($model->modules->attach_table,$model->item,$model->value,$model->f_type,0);

            return $this->redirect(['index']);
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
        }
        return ajaxReturnFailure('删除失败');
    }

    /**
     * 模型
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = ExtField::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
