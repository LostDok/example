<?php

namespace modules\client\src\useCases\auth;

use modules\client\common\models\Client;
use modules\client\src\repositories\ClientRepository;

class NetworkService
{
    private $users;

    public function __construct(ClientRepository $users)
    {
        $this->users = $users;
    }

    public function auth($network, $identity): Client
    {
        if ($user = $this->users->findByNetworkIdentity($network, $identity)) {
            return $user;
        }
        $user = Client::signupByNetwork($network, $identity);
        $this->users->save($user);
        return $user;
    }

    public function attach($id, $network, $identity): void
    {
        if ($this->users->findByNetworkIdentity($network, $identity)) {
            throw new \DomainException('Network is already signed up.');
        }
        $user = $this->users->get($id);
        $user->attachNetwork($network, $identity);
        $this->users->save($user);
    }
}