<?php

namespace frontend\models\user;

use common\models\User;
use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $passwordRepeat;

    public int $userId;

    /**
     * @var User
     */
    private $user;

    public function formName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['userId'],
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => ['userId' => 'id']
            ],
            [['currentPassword', 'newPassword', 'passwordRepeat'], 'required'],
            [['newPassword'], 'compare', 'compareAttribute' => 'passwordRepeat'],
            [['newPassword'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }


    public function change(): bool
    {
        if (
            !$this->validate()
            || !$this->getUser()->validatePassword($this->currentPassword)
        ) {
            return false;
        }

        $this->setUser(User::findOne(['id' => $this->userId]));

        $user = $this->getUser();
        $user->setPassword($this->newPassword);
        $user->update();

        return true;
    }
}