<?php

namespace collect\controllers;

use collect\Module;
use common\models\AttachTable;
use common\models\Channel;
use common\models\Content;
use Yii;
use common\models\CollectHtml;
use common\models\searchs\CollectHtml as CollectHtmlSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class CollecthtmlController
 * @package collect\controllers
 */
class CollecthtmlController extends Controller
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
        $searchModel = new CollectHtmlSearch();
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
            $post_data = Yii::$app->request->post('CollectHtml');
            $data = CollectHtml::filterPrefix2Array($post_data,'ext_');
            $model->title = $data['title'];
            $model->content = serialize([$data]);
            $model->update_addtime = GTIME;
            if ($model->save(false)) {
                return $this->redirect(['index']);
            }
        }
        if($model->content){
            $result = unserialize($model->content);
            $model->attributes = CollectHtml::addPrefix2Array($result[0],'ext_');
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
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
     * 内容入库
     * @param int $c_id
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionPushindex($c_id = 0){
        $model = new Content();
        $channelModel = Channel::find()->where(['status' => 1,'m_id' => 1])->asArray()->all();
        $channelDropdown = Channel::getDropdownChannelList($channelModel);
        return $this->render('pushindex', [
            'c_id' => $c_id,
            'model' => $model,
            'channelDropdown' => $channelDropdown
        ]);
    }

    /**
     * 采集数据入正式库
     * @param int $c_id
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionStorage($c_id = 0){
        $model = new Content();
        $model->load(Yii::$app->request->post());
        //模型
        $modelModule = \common\models\Module::findOne(['id'=>1,'status'=>1]);
        if(!$modelModule){
            return ajaxReturnFailure('模型不存在');
        }
        //附加表模型
        $attachTableModel = new AttachTable();
        $attachTableModel::$tableName = $modelModule->attach_table;
        //入库数据
        $data = CollectHtml::find()->where(['c_id'=>$c_id,'is_down'=>1,'is_export'=>0])->asArray()->all();
        if(!$data){
            return ajaxReturnFailure('暂无要入库的数据或已入库成功');
        }
        $count = count($data);
        $succ_num = $err_num= 0;
        foreach ($data as $key => $val){
            $transaction = Yii::$app->db->beginTransaction();
            $content = unserialize($val['content'])[0];
            $main_table = $content;
            $main_table['m_id'] = $modelModule->id;
            $main_table['p_id'] = $model->p_id;
            $main_table['create_addtime'] = GTIME;
            $main_table['status'] = 0;
            $main_table['create_user'] = Yii::$app->user->identity->username;
            $model->isNewRecord = true;
            $model->attributes = $main_table;
            unset($model->id);
            //主表数据更新
            if($model->save(false)){
                $ext_table['id'] = $model->attributes['id'];
                $ext_table['p_id'] = $model->p_id;
                $ext_table['body'] = $content['content'];
                $attachTableModel->isNewRecord = true;
                $attachTableModel->setAttributes($ext_table,false);
                //附加表数据更新
                if(!$attachTableModel->save(false)){
                    $transaction->rollBack();
                    return ajaxReturnFailure('附加表数据入库失败！');
                }
                //临时采集内容状态更新
                if(!CollectHtml::updateAll(['is_export'=>1],['id'=>$val['id'],'c_id'=>$c_id])){
                    $transaction->rollBack();
                    return ajaxReturnFailure('临时采集内容状态修改失败！');
                }
                $succ_num++;
                $transaction->commit();
            }else{
                $transaction->rollBack();
                return ajaxReturnSuccess('主表数据入库失败！');
            }
            if(($key % 10) === 0){ //循环10条数据休眠N秒
                sleep($model->seconds);
            }
        }
        return ajaxReturnSuccess("共入库{$count}条数据，成功{$succ_num}条，失败{$err_num}条！");
    }

    /**
     * 模型
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = CollectHtml::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
