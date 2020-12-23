<?php

namespace modules\client\src\useCases\auth;

use modules\client\common\models\Client;
use modules\client\src\forms\auth\SignupForm;
use modules\client\src\repositories\ClientRepository;

class SignupService
{
    private $clients;

    public function __construct(ClientRepository $clients)
    {
        $this->clients = $clients;
    }

    public function signup(SignupForm $form): Client
    {
        $client = Client::requestSignup(
            $form->email,
            $form->password
        );
        $this->clients->save($client);
        return $client;
    }

    public function confirm($token): Client
    {
        if (empty($token)) {
            throw new \DomainException('Токен активации пустой.');
        }
        $client = $this->clients->getByEmailConfirmToken($token);
        $client->confirmSignup();
        $this->clients->save($client);
        return $client;
    }

    public function requestActivation($email): void
    {
        $client = $this->clients->getByEmail($email);
        $client->requestActivation();
        $this->clients->save($client);
    }
}