<?php


namespace modules\client\src\repositories;


use common\lib\dispatchers\EventDispatcher;
use common\lib\repositories\NotFoundException;
use modules\client\common\models\Client;

class ClientRepository
{
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function findByEmail($email): ?Client
    {
        return Client::find()->andWhere(['email' => $email])->limit(1)->one();
    }

    public function findByNetworkIdentity($network, $identity): ?Client
    {
        return Client::find()->joinWith('networks n')->andWhere(['n.network' => $network, 'n.identity' => $identity])->one();
    }

    public function get($id): Client
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByEmail($email)
    {
        return $this->getBy(['email' => $email]);
    }

    public function getByEmailConfirmToken($token)
    {
        return $this->getBy(['email_confirm_token' => $token]);
    }

    public function getByPasswordResetToken($token)
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool) Client::findByPasswordResetToken($token);
    }

    public function save(Client $client): void
    {
        if (!$client->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
        $this->dispatcher->dispatchAll($client->releaseEvents());
    }

    public function remove(Client $user): void
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
        $this->dispatcher->dispatchAll($user->releaseEvents());
    }

    private function getBy(array $condition): Client
    {
        if (!$client = Client::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('Клиент не найден.');
        }
        return $client;
    }
}