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
                'head' => $model->head,
                'encode' => $model->encoding,
                'reverse' => $model->reverse,
                'is_guard' => $model->is_guard,
                'referer' => $model->referer,
            ];
            $rule_list = [];
            if($model->list_rules_title){
                $rule_list['title'] = [$model->list_rules_title,'text'];
            }
            if($model->list_rules_url){
                $rule_list['url'] = [$model->list_rules_url,'href'];
            }
            if($model->list_rules_thumb){
                $rule_list['thumb'] = [$model->list_rules_thumb,'src'];
            }
            //列表匹配规则
            $listconfig = [
                'url' => $model->list_url,
                'range' => $model->list_range,
                'rules' => $rule_list
            ];
            $rule_content = [];
            if($model->content_rules_title){
                $rule_content['title'] = [$model->content_rules_title,'text'];
            }
            if($model->content_rules_kw){
                $rule_content['kw'] = [$model->content_rules_kw,'text'];
            }
            if($model->content_rules_desc){
                $rule_content['desc'] = [$model->content_rules_desc,'text'];
            }
            if($model->content_rules_content){
                $rule_content['content'] = [$model->content_rules_content,'text',$model->content_rules_content_filter];
            }
            if($model->content_rules_author){
                $rule_content['author'] = [$model->content_rules_author,'text',$model->content_rules_author_filter];
            }
            if($model->content_rules_source){
                $rule_content['source'] = [$model->content_rules_source,'text',$model->content_rules_source_filter];
            }
            if($model->content_rules_click){
                $rule_content['click'] = [$model->content_rules_click,'text',$model->content_rules_click_filter];
            }
            if($model->content_rules_addtime){
                $rule_content['addtime'] = [$model->content_rules_addtime,'text',$model->content_rules_addtime_filter];
            }
            //内容匹配规则
            $arcconfig = [
                'range' => '',
                'rules' => $rule_content
            ];
            $model->baseconfig = serialize($baseconfig);
            $model->listconfig = serialize($listconfig);
            $model->arcconfig = serialize($arcconfig);
            dd($rule_content);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

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
