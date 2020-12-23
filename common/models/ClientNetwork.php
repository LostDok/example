<?php

namespace modules\client\common\models;

use Webmozart\Assert\Assert;
use yii\db\ActiveRecord;

/**
 * @property integer $client_id
 * @property string $identity
 * @property string $network
 */
class ClientNetwork extends ActiveRecord
{
    public static function create($network, $identity): self
    {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);

        $item = new static();
        $item->network = $network;
        $item->identity = $identity;
        return $item;
    }

    public function isFor($network, $identity): bool
    {
        return $this->network === $network && $this->identity === $identity;
    }
}