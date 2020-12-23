<?php
namespace modules\client\frontend\controllers\auth;

use modules\client\common\auth\Identity;
use modules\client\common\models\Client;
use modules\client\src\repositories\ClientRepository;
use modules\client\src\useCases\auth\SignupService;
use modules\client\src\useCases\auth\InactiveException;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use modules\client\src\forms\auth\SignupForm;
use yii\web\NotFoundHttpException;

class SignupController extends Controller
{
    private $service;
    private $repository;

    public function __construct($id, $module, SignupService $service, ClientRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function actionRequest()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $client = $this->service->signup($form);
                Yii::$app->user->login(new Identity($client));
                return $this->goBack(['/client/default/index']);
            }
            catch (\DomainException $e) {
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
     */
    public function actionConfirm($token)
    {
        try {
            $client = $this->service->confirm($token);
            Yii::$app->session->setFlash('success', 'Ваш email подтвержден.');
            Yii::$app->user->login(new Identity($client));
            return $this->goBack(['/client/default/index']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }

    public function actionActivate($email)
    {
        $client = $this->repository->findByEmail($email);
        if (!$client || $client->isActive()) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        if (Yii::$app->request->isPost) {
            try {
                $this->service->requestActivation($email);
                Yii::$app->session->setFlash('success', 'На ваш email повторно была отправлена ссылка для активации профиля.');
                return $this->refresh();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('activate', ['email' => $email]);
    }
}
