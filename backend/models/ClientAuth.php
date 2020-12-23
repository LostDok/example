<?php


namespace modules\client\backend\models;


use modules\client\common\models\Client;
use yii\base\Model;

class ClientAuth extends Model
{
    public $email;
    public $password;

    public function __construct(Client $client = null, $config = [])
    {
        if ($client) {
            $this->email = $client->email;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }
}