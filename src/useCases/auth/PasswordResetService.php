<?php

namespace modules\client\src\useCases\auth;

use modules\client\common\models\Client;
use modules\client\src\forms\auth\PasswordResetRequestForm;
use modules\client\src\forms\auth\ResetPasswordForm;
use modules\client\src\repositories\ClientRepository;
use modules\email\common\templates\ChangePasswordTemplate;
use Yii;
use yii\helpers\Html;
use yii\mail\MailerInterface;

class PasswordResetService
{
    private $mailer;
    private $clients;

    public function __construct(ClientRepository $clients, MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->clients = $clients;
    }

    public function request(PasswordResetRequestForm $form): void
    {
        $client = $this->clients->getByEmail($form->email);

        $client->requestPasswordReset();
        $this->clients->save($client);

        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/client/auth/reset/confirm', 'token' => $client->password_reset_token]);
        $template = new ChangePasswordTemplate(Yii::$app->name, Html::a(Html::encode($resetLink), $resetLink));
        $sent = $this->mailer
            ->compose()
            ->setTo($client->email)
            ->setSubject($template->getSubject())
            ->setHtmlBody($template->getMessageHtml())
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Ошибка во время отправки email.');
        }
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Токен сброса пароля не может быть пустым.');
        }
        if (!$this->clients->existsByPasswordResetToken($token)) {
            throw new \DomainException('Неверный токен сброса пароля.');
        }
    }

    public function reset(string $token, ResetPasswordForm $form): Client
    {
        $client = $this->clients->getByPasswordResetToken($token);
        $client->resetPassword($form->password);
        $this->clients->save($client);
        return $client;
    }
}