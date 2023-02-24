<?php

namespace frontend\models\user;

use common\models\User;
use common\models\UserDetails;
use Throwable;
use Yii;
use yii\base\Model;
use yii\db\Exception;

class EditUserForm extends Model
{
    /** @var int */
    public int $userId;

    /** @var string */
    public string $email;
    public string $firstName;
    public string $lastName;
    public string $phone;
    public string $address;

    public function rules()
    {
        return [
            [
                ['userId'],
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => ['userId' => 'id']
            ],
            [['email'], 'email'],
            [['firstName', 'lastName', 'address'], 'string', 'min' => 1, 'max' => 250],
            [['phone'], 'string', 'min' => 1, 'max' => 12]
        ];
    }

    public function formName()
    {
        return '';
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $userTransaction = User::getDb()->beginTransaction();
        try {
            $user = User::findOne(['id' => $this->userId]);
            $userDetails = UserDetails::findOne(['user_id' => $user->id]);

            if (!$userDetails) {
                $userDetails = new UserDetails();
                $userDetails->user_id = $user->id;
            }

            $user->email = $this->email;
            $userDetails->first_name = $this->firstName;
            $userDetails->last_name = $this->lastName;
            $userDetails->address = $this->address;
            $userDetails->phone = $this->phone;

            if ($user->save() && $userDetails->save()) {
                isset($userTransaction) && $userTransaction->commit();
                return true;
            } else {
                throw new Exception(
                    'Edit user error'
                );
            }
        } catch (Throwable $e) {
            isset($userTransaction) && $userTransaction->rollBack();
            Yii::error(['message' => $e->getMessage(), 'trace' => $e->getTrace()]);
            return false;
        }
    }
}