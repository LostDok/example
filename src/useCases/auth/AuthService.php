<?php

namespace modules\client\src\useCases\auth;

use modules\client\common\models\Client;
use modules\client\src\forms\auth\LoginForm;
use modules\client\src\repositories\ClientRepository;

class AuthService
{
    private $clients;

    public function __construct(ClientRepository $clients)
    {
        $this->clients = $clients;
    }

    public function auth(LoginForm $form): Client
    {
        $client = $this->clients->findByEmail($form->email);
        if (!$client || !$client->validatePassword($form->password)) {
            throw new \DomainException('Неверные данные.');
        }
        if (!$client->isActive()) {
            throw new InactiveException($client, 'Email не подтвержден.');
        }
        return $client;
    }

    public function firstLogin($id, $sessionId): void
    {
        $client = $this->clients->get($id);
        $client->setFirstSession($sessionId);
        $this->clients->save($client);
    }

    public function checkInfoSufficient(int $id)
    {
        $client = $this->clients->get($id);
        return $client->isSufficient();
    }
}