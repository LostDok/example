<?php

namespace modules\client\common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%client_card}}".
 *
 * @property int $id
 * @property int $client_id
 * @property string|null $name
 * @property string|null $number
 * @property string|null $cvc
 *
 */
class ClientCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client_card}}';
    }
}
