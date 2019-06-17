<?php

namespace common\models\form;

use Yii;
use common\models\Member as User;
use yii\base\Model;

/**
 * Class ChangePassword
 * @package common\models\form
 */
class ChangePassword extends Model
{
    public $oldPassword;
    public $newPassword;
    public $retypePassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'retypePassword'], 'required'],
            [['oldPassword'], 'validatePassword'],
            [['newPassword'], 'string', 'min' => 6],
            [['retypePassword'], 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }

    /**
     * 验证密码
     */
    public function validatePassword()
    {
        /* @var $user User */
        $user = Yii::$app->user->identity;
        if (!$user || !$user->validatePassword($this->oldPassword)) {
            $this->addError('oldPassword', 'Incorrect old password.');
        }
    }

    /**
     * @return bool
     */
    public function change()
    {
        if ($this->validate()) {
            /* @var $user User */
            $user = Yii::$app->user->identity;
            $user->setPassword($this->newPassword);
            $user->generateAuthKey();
            if ($user->save()) {
                return true;
            }
        }

        return false;
    }
}
