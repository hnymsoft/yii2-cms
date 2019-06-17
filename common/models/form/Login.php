<?php

namespace common\models\form;

use Yii;
use yii\base\Model;
use common\models\Member as User;

/**
 * Class Login
 * @package common\models\form
 */
class Login extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['username','validateUsername'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '账号',
            'password' => '密码',
            'rememberMe' => '记住密码'
        ];
    }

    public function validateUsername($attribute, $params){
        if(!$this->hasErrors()){
            $user = $this->getUser();
            if(!$user){
                $this->addError($attribute, '账号错误！');
            }
        }
    }

    /**
     * 验证密码
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '密码错误！');
            }
        }
    }

    /**
     * 登陆
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->getUser()->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * 获取用户
     * @return bool|null|static
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
