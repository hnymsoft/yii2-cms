<?php

namespace system\controllers;

use common\models\Module;
use Yii;
use common\models\Channel;
use common\models\searchs\Channel as ChannelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 栏目管理
 * Class ChannelController
 * @package system\controllers
 */
class ChannelController extends Controller
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
        $searchModel = new ChannelSearch();
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
     */
    public function actionCreate()
    {
        $model = new Channel();
        if(Yii::$app->request->isPost){
            $model->level = 0;
            if(is_numeric(Yii::$app->request->post('Channel')['p_id']) && Yii::$app->request->post('Channel')['p_id'] > 0){
                $model->level = Channel::setChannelLevel(Yii::$app->request->post('Channel')['p_id']);
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->redirect(['index']);
        }
        $channelModel = Channel::find()->where(['status' => 1])->asArray()->all();
        $channelDropdown = Channel::getDropdownChannelList($channelModel);
        array_unshift($channelDropdown,['id' => 0,'name' => '顶级栏目']);
        return $this->render('create', [
            'model' => $model,
            'channelDropdown' => $channelDropdown
        ]);
    }

    /**
     * 编辑
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->redirect(['index']);
        }

        $channelModel = Channel::find()->where(['status' => 1])->asArray()->all();
        $channelDropdown = Channel::getDropdownChannelList($channelModel);
        array_unshift($channelDropdown,['id' => 0,'name' => '顶级栏目']);
        return $this->render('update', [
            'model' => $model,
            'channelDropdown' => $channelDropdown
        ]);
    }

    /**
     * 删除
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
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
        if (($model = Channel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Ajax获取栏目列表
     * @return string
     */
    public function actionAjaxchannellist(){
        $model = Channel::find()
                ->alias('c')
                ->select('c.*,m.name as m_name')
                ->leftJoin(Module::tableName().' as m','m.id = c.m_id')
                ->orderBy('c.p_id asc,c.order asc')
                ->asArray()
                ->all();
        $data = [
            'msg' => true,
            'code' => 0,
            'data' => $model,
            'count' => count($model)
        ];
        return json_encode($data);
    }

    /**
     * Ajax修改排序方式
     * @param $id
     * @param $order
     * @return string
     */
    public function actionAjaxorder($id,$order){
        $model = Channel::findOne($id);
        if(!$model){
            return ajaxReturnFailure('栏目不存在');
        }
        if(!is_numeric($order)) return ajaxReturnFailure('请输入正确的数字');
        $model->order = $order;
        if($model->save(false)){
            return ajaxReturnSuccess('排序修改成功');
        }
        return ajaxReturnFailure('排序修改失败');
    }

    /**
     * Ajax修改排序方式
     * @param $id
     * @param $order
     * @return string
     */
    public function actionAjaxstatus($id,$status){
        $model = Channel::findOne($id);
        if(!$model){
            return ajaxReturnFailure('栏目不存在');
        }
        if(!in_array($status,[0,1])) return ajaxReturnFailure('状态不正确');
        $model->status = $status;
        if($model->save(false)){
            return ajaxReturnSuccess('状态修改成功');
        }
        return ajaxReturnFailure('状态修改失败');
    }
}
