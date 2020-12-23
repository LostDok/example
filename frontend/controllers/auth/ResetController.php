<?php
namespace modules\client\frontend\controllers\auth;

use modules\client\common\auth\Identity;
use modules\client\src\useCases\auth\PasswordResetService;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use modules\client\src\forms\auth\PasswordResetRequestForm;
use modules\client\src\forms\auth\ResetPasswordForm;

class ResetController extends Controller
{
    private $service;

    public function __construct($id, $module, PasswordResetService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionRequest()
    {
        $form = new PasswordResetRequestForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->request($form);
                Yii::$app->session->setFlash('success', 'На ваш email отправлена ссылка на сброс пароля.');
                return $this->refresh();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('request', [
            'model' => $form,
        ]);
    }

    /**
     * @param $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionConfirm($token)
    {
        try {
            $this->service->validateToken($token);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $form = new ResetPasswordForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $client = $this->service->reset($token, $form);
                Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');
                Yii::$app->user->login(new Identity($client));
                return $this->goBack(['/client/default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(['auth/auth/login']);
        }

        return $this->render('confirm', [
            'model' => $form,
        ]);
    }
}
