<?php

namespace modules\client\src\listeners;

use modules\client\common\models\events\ClientSignUpRequested;
use modules\email\common\templates\RegistrationTemplate;
use Yii;
use yii\helpers\Html;
use yii\mail\MailerInterface;

class ClientSignupRequestedListener
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handle(ClientSignUpRequested $event): void
    {
        $confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/client/auth/signup/confirm', 'token' => $event->client->email_confirm_token]);
        $template = new RegistrationTemplate(Yii::$app->name, Html::a(Html::encode($confirmLink), $confirmLink));
        $sent = $this->mailer
            ->compose()
            ->setTo($event->client->email)
            ->setSubject($template->getSubject())
            ->setHtmlBody($template->getMessageHtml())
            ->send();
        if (!$sent) {
            throw new \RuntimeException('Произошла ошибка во время отправки email.');
        }
    }
}