<?php
namespace modules\client\src\forms\auth;

use yii\base\Model;
use modules\client\common\models\Client;

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => Client::class,
                'filter' => ['status' => Client::STATUS_ACTIVE],
                'message' => 'Пользователь не найден.'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
          'email' => 'Email',
        ];
    }
}
