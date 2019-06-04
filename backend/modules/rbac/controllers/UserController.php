<?php

namespace rbac\controllers;

use Yii;
use rbac\models\form\Login;
use rbac\models\form\PasswordResetRequest;
use rbac\models\form\ResetPassword;
use rbac\models\form\Signup;
use rbac\models\form\ChangePassword;
use rbac\models\User;
use rbac\models\searchs\User as UserSearch;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\base\UserException;
use yii\mail\BaseMailer;
use yii\web\ForbiddenHttpException;

/**
 * 用户管理
 * Class UserController
 * @package rbac\controllers
 */
class UserController extends Controller
{
    private $_oldMailPath;

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
                    'active' => ['post'],
					'inactive' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 用户列表
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 用户详情
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
     * 用户删除
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
		if($this->findModel($id)->delete()){
		    return ajaxReturnSuccess('删除成功~');
		}else{
		    return ajaxReturnFailure('删除失败~');
		}
    }

    /**
     * 用户状态（启用）
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionActive($id)
    {
		$model = $this->findModel($id);
		if($model->status== User::STATUS_ACTIVE){
			return ajaxReturnFailure('该用户是已经是启用状态');
		}
		$model->status = User::STATUS_ACTIVE;
		if(!$model->save(false)){
            $errors = $model->firstErrors;
            return ajaxReturnFailure(reset($errors));
		}
        return ajaxReturnSuccess('启用成功');
    }

    /**
     * 用户状态（禁用）
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionInactive($id)
    {	
		$model = $this->findModel($id);
		if($model->status== User::STATUS_INACTIVE){
			return ajaxReturnFailure('该用户是已经是禁用状态');
		}
		$model->status = User::STATUS_INACTIVE;
        if(!$model->save(false)){
            $errors = $model->firstErrors;
            return ajaxReturnFailure(reset($errors));
        }
        return ajaxReturnSuccess('禁用成功');
    }

    /**
     * 用户登陆
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        //layout文件
        $this->layout = '@backend/views/layouts/main-login';

        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }
        $model = new Login();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 用户编辑
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post_data = Yii::$app->request->post();

        if ($model->load($post_data) && $model->validate()) {
			if($post_data['User']['password_hash']){
				$model->password_hash=Yii::$app->security->generatePasswordHash($post_data['User']['password_hash']);
			}
            $model->password_reset_token = null;
            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 用户编辑（个人）
     * @param $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdateSelf($id)
    {
        $model = $this->findModel($id);
        $post_data = Yii::$app->request->post();
		
		if($id!=Yii::$app->user->identity->id){
			throw new ForbiddenHttpException('你没有权限修改');
		}
        if ($model->load($post_data) && $model->validate()) {
			if($post_data['User']['password_hash']){
				$model->password_hash=Yii::$app->security->generatePasswordHash($post_data['User']['password_hash']);
			}
            $model->password_reset_token = null;
            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 用户退出
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();
        return $this->goHome();
    }

    /**
     * 用户添加
     * @return string
     */
    public function actionSignup()
    {
        $model = new Signup();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
				return $this->render('view', [
					'model' => $user,
				]);
            }
        }
        return $this->render('signup', [
                'model' => $model,
        ]);
    }

    /**
     * 找回密码
     * @return string
     */
    public function actionRequestPasswordReset()
    {
        //layout文件
        $this->layout = '@backend/views/layouts/main-login';

        $model = new PasswordResetRequest();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                'model' => $model,
        ]);
    }

    /**
     * 重置密码
     * @param $token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * 更改密码
     * @return string
     */
    public function actionChangePassword()
    {
        $model = new ChangePassword();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->change()) {
            return $this->goHome();
        }

        return $this->render('change-password', [
                'model' => $model,
        ]);
    }

    /**
     * User模型
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
