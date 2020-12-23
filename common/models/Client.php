<?php

namespace modules\client\common\models;

use modules\client\common\models\events\ClientSignUpConfirmed;
use modules\client\common\models\events\ClientSignUpRequested;
use common\lib\entities\AggregateRoot;
use common\lib\entities\EventTrait;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%client}}".
 *
 * @property int $id
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string|null $email_confirm_token
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $first_session
 * @property string $password write-only password
 *
 * @property ClientInfo $info
 * @property ClientCard $card
 * @property ClientNetwork[] $networks
 */
class Client extends \yii\db\ActiveRecord implements AggregateRoot
{
    use EventTrait;

    public static function create($email, $password, ClientInfo $info): self
    {
        $client = new self();
        $client->email = $email;
        $client->setPassword($password);
        $client->status = self::STATUS_ACTIVE;
        $client->generateAuthKey();
        $client->info = $info;
        return $client;
    }

    public function updateAuth($email, $password): void
    {
        $this->email = $email;
        $this->setPassword($password);
    }

    public function updateSecurity($password): void
    {
        $this->setPassword($password);
    }

    public static function requestSignup($email, $password): self
    {
        $client = new self();
        $client->email = $email;
        $client->setPassword($password);
        $client->status = self::STATUS_INACTIVE;
        $client->email_confirm_token = Yii::$app->security->generateRandomString();
        $client->generateAuthKey();
        $client->info = new ClientInfo();
        $client->recordEvent(new ClientSignUpRequested($client));
        return $client;
    }

    public function confirmSignup(): void
    {
        if (!$this->isInactive()) {
            throw new \DomainException('Клиент уже активирован.');
        }
        $this->status = self::STATUS_ACTIVE;
        $this->email_confirm_token = null;
        $this->recordEvent(new ClientSignUpConfirmed($this));
    }

    public function requestActivation()
    {
        $this->guardRequestActivationSpam();
        $this->email_confirm_token = Yii::$app->security->generateRandomString() . '_' . time();
        $this->recordEvent(new ClientSignUpRequested($this));
    }

    private function guardRequestActivationSpam()
    {
        if (strrpos($this->email_confirm_token, '_') === false)
            return;
        $timestamp = (int)substr($this->email_confirm_token, strrpos($this->email_confirm_token, '_') + 1);
        $expire = Yii::$app->params['client.activationTokenExpire'];
        if ($timestamp + $expire < time()) {
            throw new \DomainException('Запрос на активацию уже существует.');
        }
    }

    public static function signupByNetwork($network, $identity): self
    {
        $client = new Client();
        $client->status = self::STATUS_ACTIVE;
        $client->generateAuthKey();
        $client->networks = [ClientNetwork::create($network, $identity)];
        return $client;
    }

    public function attachNetwork($network, $identity): void
    {
        $networks = $this->networks;
        foreach ($networks as $current) {
            if ($current->isFor($network, $identity)) {
                throw new \DomainException('Социальная сесть уже прикреплена.');
            }
        }
        $networks[] = ClientNetwork::create($network, $identity);
        $this->networks = $networks;
    }

    public function setProductInfo($name, $surname, $workLineId, $phone, $cardName, $cardNumber, $cvc)
    {
        $info = $this->info;
        $info->name = $name;
        $info->surname = $surname;
        $info->work_line_id = $workLineId;
        $this->info = $info;
        $info->phone = $phone;
        $card = $this->card ?: new ClientCard(['client_id' => $this->id]);
        $card->name = $cardName;
        $card->number = $cardNumber;
        $card->cvc = $cvc;
        $this->card = $card;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    public function isSufficient(): bool
    {
        return
            $this->info->name
            && $this->info->surname
            && $this->info->work_line_id
            && $this->info->phone
            && $this->card;
    }

    public function requestPasswordReset(): void
    {
        if (!empty($this->password_reset_token) && self::isPasswordResetTokenValid($this->password_reset_token)) {
            throw new \DomainException('Запрос на сброс пароля уже существует.');
        }
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function resetPassword($password)
    {
        if (empty($this->password_reset_token)) {
            throw new \DomainException('Запрос на сброс пароля не существует.');
        }
        $this->setPassword($password);
        $this->password_reset_token = null;
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['client.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * ===============================================================
     */

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @var array
     */
    public static $statuses = [
        self::STATUS_INACTIVE => 'Неактивный',
        self::STATUS_ACTIVE => 'Активный',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email_confirm_token' => 'Email Confirm Token',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ],
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['info', 'card', 'networks'],
            ],
        ];
    }

    public function getInfo(): ActiveQuery
    {
        return $this->hasOne(ClientInfo::class, ['client_id' => 'id']);
    }

    public function getCard(): ActiveQuery
    {
        return $this->hasOne(ClientCard::class, ['client_id' => 'id']);
    }

    public function getNetworks(): ActiveQuery
    {
        return $this->hasMany(ClientNetwork::class, ['client_id' => 'id']);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setFirstSession($sessionId)
    {
        if ($this->first_session) {
            throw new \DomainException('Первая сессия уже была.');
        }
        $this->first_session = $sessionId;
    }
}
