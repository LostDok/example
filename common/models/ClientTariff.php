<?php

namespace modules\client\common\models;

use Yii;

/**
 * This is the model class for table "{{%client_tariff}}".
 *
 * @property int $client_id
 * @property int $tariff_id
 * @property int $created_at
 * @property int $expired_at

 * @property Client $client
 */
class ClientTariff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client_tariff}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'tariff_id', 'expired_at'], 'required'],
            [['client_id', 'tariff_id', 'created_at', 'expired_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client ID',
            'tariff_id' => 'Tariff ID',
            'created_at' => 'Created At',
            'expired_at' => 'Expired At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }
}
