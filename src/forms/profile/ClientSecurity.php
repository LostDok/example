<?php


namespace modules\client\src\forms\profile;


use modules\client\common\models\Client;
use yii\base\Model;

class ClientSecurity extends Model
{
    public $oldPassword;
    public $newPassword;
    public $newPassword2;

    private Client $client;

    public function __construct(Client $client, $config = [])
    {
        parent::__construct($config);
        $this->client = $client;
    }

    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'newPassword2'], 'required'],
            [['oldPassword', 'newPassword', 'newPassword2'], 'string', 'min' => 6],
            ['oldPassword', 'validateOldPassword'],
            ['newPassword', 'compare', 'compareAttribute' => 'oldPassword', 'operator' => '!='],
            ['newPassword2', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли не совпадают.'],
        ];
    }

    public function validateOldPassword($attribute, $params)
    {
        if (!$this->client->validatePassword($this->{$attribute})) {
            $this->addError($attribute, 'Неверный пароль');
        }
    }

    public function attributeLabels()
    {
        return [
          'oldPassword' => 'Старый пароль',
          'newPassword' => 'Новый пароль',
          'newPassword2' => 'Новый пароль еще раз',
        ];
    }
}