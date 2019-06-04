<?php

namespace rbac\controllers;

use Yii;
use rbac\models\Menu;
use rbac\models\searchs\Menu as MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use rbac\components\Helper;

/**
 * 菜单
 * @package rbac\controllers
 */
class MenuController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 菜单列表
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * 菜单详情
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
     * 添加菜单
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Menu;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Helper::invalidate();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 编辑菜单
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->menuParent) {
            $model->parent_name = $model->menuParent->name;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Helper::invalidate();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 删除菜单
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		if($model->delete()){
			Helper::invalidate();
			return ajaxReturnSuccess('删除成功');
		}else{
			$errors = $model->firstErrors;
			return ajaxReturnFailure(reset($errors));
		}
    }

    /**
     * 删除菜单（多条）
     * @return string
     */
    public function actionDeleteAll(){
        $data = Yii::$app->request->post();
        if($data){
            $model = new Menu;
            $count = $model->deleteAll(["in","id",$data['keys']]);
            if($count>0){
				Helper::invalidate();
				return ajaxReturnSuccess('删除成功');
            }else{
				$errors = $model->firstErrors;
				return ajaxReturnFailure(reset($errors));
            }
        }else{
            return ajaxReturnFailure('请选择数据');
        }
    }

    /**
     * 模型
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
