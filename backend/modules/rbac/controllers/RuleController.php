<?php

namespace rbac\controllers;

use Yii;
use rbac\models\BizRule;
use yii\web\Controller;
use rbac\models\searchs\BizRule as BizRuleSearch;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use rbac\components\Helper;
use rbac\components\Configs;

/**
 * 规则
 * @package rbac\controllers
 */
class RuleController extends Controller
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
     * 规则列表
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BizRuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * 规则详情
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * 添加规则
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new BizRule(null);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Helper::invalidate();

            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }

    /**
     * 编辑规则
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Helper::invalidate();

            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('update', ['model' => $model,]);
    }

    /**
     * 删除规则
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		if(Configs::authManager()->remove($model->item)){
			Helper::invalidate();
			return ajaxReturnSuccess('删除成功');
		}else{
			$errors = $model->firstErrors;
			return ajaxReturnFailure(reset($errors));
		}
    }

    /**
     * 模型
     * @param $id
     * @return BizRule
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $item = Configs::authManager()->getRule($id);
        if ($item) {
            return new BizRule($item);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
