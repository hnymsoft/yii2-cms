<?php

namespace rbac\components;

use Yii;
use rbac\models\AuthItem;
use rbac\models\searchs\AuthItem as AuthItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\NotSupportedException;
use yii\filters\VerbFilter;
use yii\rbac\Item;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 *
 * @property integer $type
 * @property array $labels
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ItemController extends Controller
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
                    'assign' => ['post'],
                    'remove' => ['post'],
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
        $searchModel = new AuthItemSearch(['type' => $this->type]);

        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * 添加
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AuthItem(null);
        $model->type = $this->type;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', ['model' => $model]);
        }
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
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * 删除
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
            return ajaxReturnSuccess(reset($errors));
		}
    }

    /**
     * 分配权限
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $success = $model->addChildren($items);
        Yii::$app->getResponse()->format = 'json';

        return array_merge($model->getItems(), ['success' => $success]);
    }

    /**
     * 移除权限
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionRemove($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $success = $model->removeChildren($items);
        Yii::$app->getResponse()->format = 'json';

        return array_merge($model->getItems(), ['success' => $success]);
    }

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'item';
    }

    /**
     * Label use in view
     * @throws NotSupportedException
     */
    public function labels()
    {
        throw new NotSupportedException(get_class($this) . ' does not support labels().');
    }

    /**
     * 模型
     * @param $id
     * @return AuthItem
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $auth = Configs::authManager();
        $item = $this->type === Item::TYPE_ROLE ? $auth->getRole($id) : $auth->getPermission($id);
        if ($item) {
            return new AuthItem($item);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @inheritdoc
     */
    public function getType(){}
}
