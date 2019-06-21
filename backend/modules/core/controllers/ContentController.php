<?php

namespace core\controllers;

use common\models\AttachTable;
use common\models\Channel;
use common\models\ExtField;
use common\models\Module;
use Yii;
use common\models\Content;
use common\models\searchs\Content as ContentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class ContentController
 * @package core\controllers
 */
class ContentController extends Controller
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
        $m_id = Yii::$app->request->get('m_id');

        $searchModel = new ContentSearch();
        $searchModel->m_id = $m_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $channelModel = Channel::find()->where(['status' => 1,'m_id' => $m_id])->asArray()->all();
        $channelDropdown = Channel::getDropdownChannelList($channelModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'channelDropdown' => $channelDropdown
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
    public function actionCreate($m_id)
    {
        $model = new Content();
        $model->m_id = $m_id;
        $model->author = 'admin';
        $model->click = 100;
        $model->status = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }else{
            $extend_filed = ExtField::find()->where(['m_id' => $m_id])->asArray()->all();
            $channelModel = Channel::find()->where(['status' => 1,'m_id' => $m_id])->asArray()->all();
            $channelDropdown = Channel::getDropdownChannelList($channelModel);
            $moduleModel = Module::findOne($m_id);
            if($moduleModel){
                $attachTableModel = new AttachTable($moduleModel->attach_table);
                return $this->render('create', [
                    'model' => $model,                       //内容模型
                    'attachTableModel' => $attachTableModel, //附加表模型
                    'extend_filed' => $extend_filed,
                    'channelDropdown' => $channelDropdown
                ]);
            }else{
                exit('附加表不存在');
            }
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
     * 模型
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
