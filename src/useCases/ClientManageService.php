<?php


namespace modules\client\src\useCases;


use modules\client\backend\models\ClientAuth;
use modules\client\backend\models\ClientCreateForm;
use modules\client\common\models\Client;
use modules\client\src\repositories\ClientRepository;

class ClientManageService
{
    protected ClientRepository $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ClientCreateForm $form)
    {
        $client = Client::create($form->auth->email, $form->auth->password, $form->info);
        $this->repository->save($client);
        return $client;
    }

    public function updateAuth($id, ClientAuth $auth)
    {
        $client = $this->repository->get($id);
        $client->updateAuth($auth->email, $auth->password);
        $this->repository->save($client);
    }
}