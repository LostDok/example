<?php


namespace modules\client\backend\models;


use elisdn\compositeForm\CompositeForm;
use modules\client\common\models\Client;
use modules\client\common\models\ClientInfo;

/**
 * @property ClientInfo $info
 */
class ClientUpdateForm extends CompositeForm
{
    public function __construct(Client $client, $config = [])
    {
        $this->info = $client->info;
        parent::__construct($config);
    }

    protected function internalForms()
    {
        return ['info'];
    }
}