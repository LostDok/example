<?php


namespace modules\client\src\useCases\auth;


use modules\client\common\models\Client;
use Throwable;

class InactiveException extends \DomainException
{
    public Client $client;

    public function __construct(Client $client, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->client = $client;
    }
}