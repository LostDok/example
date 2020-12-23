<?php

namespace modules\client\src\readModels;

use modules\client\common\models\Client;

class ClientReadRepository
{
    public function find($id): ?Client
    {
        return Client::findOne($id);
    }

    public function findActiveByEmail($email): ?Client
    {
        return Client::findOne(['email' => $email, 'status' => Client::STATUS_ACTIVE]);
    }

    public function findActiveById($id, $session): ?Client
    {
        return Client::find()
            ->where(['id' => $id])
            ->andWhere([
                'or',
                ['status' => Client::STATUS_ACTIVE],
                ['or', ['first_session' => null], ['first_session' => $session]]
            ])->limit(1)->one();
    }
}