<?php

namespace collect\controllers;

use Yii;
use common\models\Collect;
use common\models\searchs\Collect as CollectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class CollectController
 * @package collect\controllers
 */
class CollectController extends Controller
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
        $searchModel = new CollectSearch();
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
        $model = new Collect();
        $model->encoding = 0;
        $model->status = 1;
        if(Yii::$app->request->isPost){
            if(!$model->load(Yii::$app->request->post())){
                exit('数据填充失败！');
            }
            $baseconfig = [
                'encoding' => $model->encoding,
                'is_head' => $model->is_head,
                'is_reverse' => $model->is_reverse,
                'is_ref' => $model->is_ref,
                'is_ref_url' => $model->is_ref_url,
                'is_thumb' => $model->is_thumb
            ];
            $rule_list = [];
            if($model->list_rules_url){
                $rule_list['list_rules_url'] = [$model->list_rules_url,'href'];
            }
            if($model->list_rules_title){
                $rule_list['list_rules_title'] = [$model->list_rules_title,'text'];
            }
            if($model->list_rules_thumb){
                $rule_list['list_rules_thumb'] = [$model->list_rules_thumb,'src'];
            }
            //列表匹配规则
            $listconfig = [
                'list_url' => $model->list_url,
                'list_range' => $model->list_range,
                'list_rules' => $rule_list
            ];
            $rule_content = [];
            if($model->content_rules_title){
                $rule_content['content_rules_title'] = [$model->content_rules_title,'text'];
            }
            if($model->content_rules_kw){
                $rule_content['content_rules_kw'] = [$model->content_rules_kw,'text'];
            }
            if($model->content_rules_desc){
                $rule_content['content_rules_desc'] = [$model->content_rules_desc,'text'];
            }
            if($model->content_rules_content){
                $rule_content['content_rules_content'] = [$model->content_rules_content,'text',$model->content_rules_content_filter];
            }
            if($model->content_rules_author){
                $rule_content['content_rules_author'] = [$model->content_rules_author,'text',$model->content_rules_author_filter];
            }
            if($model->content_rules_source){
                $rule_content['content_rules_source'] = [$model->content_rules_source,'text',$model->content_rules_source_filter];
            }
            if($model->content_rules_click){
                $rule_content['content_rules_click'] = [$model->content_rules_click,'text',$model->content_rules_click_filter];
            }
            if($model->content_rules_addtime){
                $rule_content['content_rules_addtime'] = [$model->content_rules_addtime,'text',$model->content_rules_addtime_filter];
            }
            //内容匹配规则
            $arcconfig = [
                'content_range' => $model->content_range,
                'content_rules' => $rule_content
            ];
            $model->baseconfig = serialize($baseconfig);
            $model->listconfig = serialize($listconfig);
            $model->arcconfig = serialize($arcconfig);
            $model->create_addtime = GTIME;
            $model->create_user = Yii::$app->user->identity->username;
            if ($model->save()) {
                return $this->redirect(['index']);
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
            if(!$model->load(Yii::$app->request->post())){
                exit('数据填充失败！');
            }
            $baseconfig = [
                'encoding' => $model->encoding,
                'is_head' => $model->is_head,
                'is_reverse' => $model->is_reverse,
                'is_ref' => $model->is_ref,
                'is_ref_url' => $model->is_ref_url,
                'is_thumb' => $model->is_thumb
            ];
            $rule_list = [];
            if($model->list_rules_url){
                $rule_list['list_rules_url'] = [$model->list_rules_url,'href'];
            }
            if($model->list_rules_title){
                $rule_list['list_rules_title'] = [$model->list_rules_title,'text'];
            }
            if($model->list_rules_thumb){
                $rule_list['list_rules_thumb'] = [$model->list_rules_thumb,'src'];
            }
            //列表匹配规则
            $listconfig = [
                'list_url' => $model->list_url,
                'list_range' => $model->list_range,
                'list_rules' => $rule_list
            ];
            $rule_content = [];
            if($model->content_rules_title){
                $rule_content['content_rules_title'] = [$model->content_rules_title,'text'];
            }
            if($model->content_rules_kw){
                $rule_content['content_rules_kw'] = [$model->content_rules_kw,'text'];
            }
            if($model->content_rules_desc){
                $rule_content['content_rules_desc'] = [$model->content_rules_desc,'text'];
            }
            if($model->content_rules_content){
                $rule_content['content_rules_content'] = [$model->content_rules_content,'text',$model->content_rules_content_filter];
            }
            if($model->content_rules_author){
                $rule_content['content_rules_author'] = [$model->content_rules_author,'text',$model->content_rules_author_filter];
            }
            if($model->content_rules_source){
                $rule_content['content_rules_source'] = [$model->content_rules_source,'text',$model->content_rules_source_filter];
            }
            if($model->content_rules_click){
                $rule_content['content_rules_click'] = [$model->content_rules_click,'text',$model->content_rules_click_filter];
            }
            if($model->content_rules_addtime){
                $rule_content['content_rules_addtime'] = [$model->content_rules_addtime,'text',$model->content_rules_addtime_filter];
            }
            //内容匹配规则
            $arcconfig = [
                'content_range' => $model->content_range,
                'content_rules' => $rule_content
            ];
            $model->baseconfig = serialize($baseconfig);
            $model->listconfig = serialize($listconfig);
            $model->arcconfig = serialize($arcconfig);
            $model->update_user = Yii::$app->user->identity->username;
            if ($model->save(false)) {
                return $this->redirect(['index']);
            }
        }
        $listconfig = unserialize($model->listconfig);
        $list_rules = $listconfig['list_rules'];
        foreach ($list_rules as $key => $val){
            if(isset($val[0])){
                $listconfig[$key] = $val[0];
            }
        }
        $arcconfig = unserialize($model->arcconfig);
        $content_rules = $arcconfig['content_rules'];
        foreach ($content_rules as $key => $val){
            if(isset($val[0])){
                $arcconfig[$key] = $val[0];
            }
            if(isset($val[2]) && in_array($key,['content_rules_content','content_rules_author','content_rules_source','content_rules_click','content_rules_addtime'])){
                $filter = $key.'_filter';
                $arcconfig[$filter] = $val[2];
            }
        }
        unset($listconfig['list_rules'],$arcconfig['content_rules']);

        $baseconfig = unserialize($model->baseconfig);
        $attr = array_merge($baseconfig,$listconfig,$arcconfig);
        $model->attributes = $attr;
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Collect model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Collect model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Collect the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Collect::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
