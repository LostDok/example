<?php

namespace modules\client\common\models\events;

use modules\client\common\models\Client;

class ClientSignUpConfirmed
{
    public $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}