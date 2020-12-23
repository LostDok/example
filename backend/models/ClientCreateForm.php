<?php


namespace modules\client\backend\models;


use elisdn\compositeForm\CompositeForm;
use modules\client\common\models\ClientInfo;

/**
 * @property ClientAuth $auth
 * @property ClientInfo $info
 */
class ClientCreateForm extends CompositeForm
{
    public function __construct($config = [])
    {
        $this->auth = new ClientAuth();
        $this->info = new ClientInfo();
        parent::__construct($config);
    }

    protected function internalForms()
    {
        return ['info', 'auth'];
    }
}