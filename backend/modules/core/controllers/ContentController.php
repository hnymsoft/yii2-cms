<?php

namespace core\controllers;

use backend\controllers\BaseController;
use common\models\AttachTable;
use common\models\Channel;
use common\models\ExtField;
use common\models\Module;
use Yii;
use common\models\Content;
use common\models\searchs\Content as ContentSearch;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class ContentController
 * @package core\controllers
 */
class ContentController extends BaseController
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
     * @param $m_id     模型ID
     * @return string
     */
    public function actionCreate($m_id)
    {
        $model = new Content();
        $model->m_id = $m_id;
        $model->author = 'admin';
        $model->click = 100;
        $model->status = 1;
        $moduleModel = Module::findOne($m_id);
        if(!$moduleModel){
            exit('模型不存在');
        }
        $attachTableModel = new AttachTable();
        $attachTableModel::$tableName = $moduleModel->attach_table;
        if(Yii::$app->request->isPost){
            $transaction = Yii::$app->db->beginTransaction();
            if ($model->load(Yii::$app->request->post(),'Content')) {
                $model->flag = !empty(post('Content')['flag']) ? implode(',',post('Content')['flag']) : '';
                if($model->save(false)){
                    //附加表数据整合
                    $attachTableModel->id = $model->attributes['id'];
                    $attachTableModel->p_id = $model->p_id;
                    //附加表动态赋值
                    if(post('AttachTable')){
                        foreach (post('AttachTable') AS $key => $val){
                            $attachTableModel->{$key} = $val;
                        }
                    }
                    if($attachTableModel->save(false)){
                        $transaction->commit();
                        return $this->redirect(['index','m_id'=>$m_id]);
                    }else{
                        $transaction->rollBack();
                        exit('附加表内容添加失败');
                    }
                }else{
                    $transaction->rollBack();
                    exit('主表内容添加失败');
                }
            }
        }

        $extend_filed = ExtField::find()->where(['m_id' => $m_id])->asArray()->all();
        $channelModel = Channel::find()->where(['status' => 1,'m_id' => $m_id])->asArray()->all();
        if(!$channelModel){
            exit('当前模型栏目为空，请创建后操作！');
        }
        $channelDropdown = Channel::getDropdownChannelList($channelModel);
        return $this->render('create', [
            'model' => $model,                       //内容模型
            'attachTableModel' => $attachTableModel, //附加表模型
            'extend_filed' => $extend_filed,
            'channelDropdown' => $channelDropdown,
            'thumb_list' => []
        ]);
    }

    /**
     * 更新
     * @param $id
     * @param $m_id     模型ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id,$m_id)
    {
        $model = $this->findModel($id);

        //获取模型数据表
        $moduleModel = Module::findOne($m_id);
        AttachTable::$tableName = $moduleModel->attach_table;
        $attachTableModel = AttachTable::findOne(['id' => $model->id,'p_id' => $model->p_id]);
        if(Yii::$app->request->isPost){
            $transaction = Yii::$app->db->beginTransaction();
            if ($model->load(Yii::$app->request->post())) {
                $model->flag = !empty(post('Content')['flag']) ? implode(',',post('Content')['flag']) : '';
                if($model->save(false)){
                    //附加表数据整合
                    $attachTableModel->id = $model->id;
                    $attachTableModel->p_id = $model->p_id;
                    //附加表动态赋值
                    if(post('AttachTable')){
                        foreach (post('AttachTable') AS $key => $val){
                            $attachTableModel->{$key} = $val;
                        }
                    }
                    if($attachTableModel->save(false)){
                        $transaction->commit();
                        return $this->redirect(['index','m_id'=>$m_id]);
                    }else{
                        $transaction->rollBack();
                        exit('附加表内容更新失败');
                    }
                }
            }else{
                $transaction->rollBack();
                exit('主表数据更新失败');
            }
        }

        //主表数据整合
        $model->flag = !empty($model->flag) ? explode(',',$model->flag) : '';

        $extend_filed = ExtField::find()->where(['m_id' => $m_id])->asArray()->all();
        //图库模型
        $thumb_list = [];
        if($m_id == 2 && $attachTableModel->imgurls){
            $thumb_list = explode('|',substr($attachTableModel->imgurls,0,strlen($attachTableModel->imgurls)-1));
        }
        $channelModel = Channel::find()->where(['status' => 1,'m_id' => $m_id])->asArray()->all();
        if(!$channelModel){
            exit('当前模型栏目为空，请创建后操作！');
        }
        $channelDropdown = Channel::getDropdownChannelList($channelModel);
        return $this->render('update',[
            'model' => $model,
            'attachTableModel' => $attachTableModel,
            'extend_filed' => $extend_filed,
            'channelDropdown' => $channelDropdown,
            'thumb_list' => $thumb_list
        ]);
    }

    /**
     * 删除
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete()){
            //删除附加表信息
            $moduleModel = Module::findOne($model->m_id);
            $query = (new Query())->from($moduleModel->attach_table)->where([
                            'id' => $model->id,
                            'p_id' => $model->p_id
                        ])->count();
            if($query){
                $res = Yii::$app->db->createCommand()->delete($moduleModel->attach_table,['id' => $model->id,'p_id' => $model->p_id])->execute();
                if(!$res){
                    return ajaxReturnSuccess('附加表删除失败');
                }
            }
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
        $status = post('status');
        if(!$status || !in_array($status,[0,1])){
            return ajaxReturnFailure('参数错误');
        }
        $model = $this->findModel($id);
        $model->status = $status;
        if($model->save(false)){
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
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
