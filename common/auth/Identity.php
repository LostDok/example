<?php

namespace modules\client\common\auth;

use filsh\yii2\oauth2server\Module;
use OAuth2\Storage\UserCredentialsInterface;
use modules\client\common\models\Client;
use modules\client\src\readModels\ClientReadRepository;
use Yii;
use yii\web\IdentityInterface;

class Identity implements IdentityInterface, UserCredentialsInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public static function findIdentity($id)
    {
        $user = self::getRepository()->findActiveById($id, Yii::$app->session->getId());
        return $user ? new self($user): null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $data = self::getOauth()->getServer()->getResourceController()->getToken();
        return !empty($data['user_id']) ? static::findIdentity($data['user_id']) : null;
    }

    public function getId(): int
    {
        return $this->client->id;
    }

    public function getAuthKey(): string
    {
        return $this->client->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    public function checkUserCredentials($email, $password): bool
    {
        if (!$user = self::getRepository()->findActiveByEmail($email)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    public function getUserDetails($email): array
    {
        $user = self::getRepository()->findActiveByEmail($email);
        return ['user_id' => $user->id];
    }

    private static function getRepository(): ClientReadRepository
    {
        return \Yii::$container->get(ClientReadRepository::class);
    }

    private static function getOauth(): Module
    {
        return Yii::$app->getModule('oauth2');
    }
}