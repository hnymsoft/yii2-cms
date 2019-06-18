<?php
namespace rbac\models\form;

use common\models\Setting;
use Yii;
use rbac\models\User;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequest extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => 'rbac\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                //是否开启邮件发送功能
                if(Setting::getConfInfo('cfg_smtp_open')->value){
                    $mailer = \Yii::$app->mailer;
                    $mailer->transport = [
                        'host' => Setting::getConfInfo('cfg_smtp_server')->value,  //每种邮箱的host配置不一样
                        'port' => Setting::getConfInfo('cfg_smtp_port')->value,
                        'encryption' => Setting::getConfInfo('cfg_smtp_ssl')->value == 1 ? 'tls' : '',
                        'username' => Setting::getConfInfo('cfg_smtp_username')->value,
                        'password' => Setting::getConfInfo('cfg_smtp_password')->value,
                    ];
                    $mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                        ->setTo($this->email)
                        ->setSubject('Password reset for ' . Yii::$app->name)
                        ->send();
                }else{
                    return false;
                }
            }
        }

        return false;
    }
}
