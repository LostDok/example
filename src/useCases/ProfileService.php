<?php


namespace modules\client\src\useCases;


use modules\client\backend\models\ClientAuth;
use modules\client\backend\models\ClientCreateForm;
use modules\client\common\models\Client;
use modules\client\src\forms\profile\ClientSecurity;
use modules\client\src\forms\profile\ProductInfo;
use modules\client\src\repositories\ClientRepository;

class ProfileService
{
    protected ClientRepository $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updateAuth($id, ClientAuth $auth)
    {
        $client = $this->repository->get($id);
        $client->updateAuth($auth->email, $auth->password);
        $this->repository->save($client);
    }

    public function updateSecurity($id, ClientSecurity $security)
    {
        $client = $this->repository->get($id);
        $client->updateSecurity($security->newPassword);
        $this->repository->save($client);
    }

    public function setProductInfo($id, ProductInfo $model)
    {
        $client = $this->repository->get($id);
        $client->setProductInfo(
            $model->name,
            $model->surname,
            $model->workLineId,
            $model->phone,
            $model->cardName,
            $model->cardNumber,
            $model->cvc
        );
        $this->repository->save($client);
    }
}