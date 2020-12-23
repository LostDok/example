<?php
namespace modules\client\frontend\controllers\auth;

use modules\client\common\auth\Identity;
use modules\client\src\useCases\auth\AuthService;
use modules\client\src\useCases\auth\InactiveException;
use Yii;
use yii\web\Controller;
use modules\client\src\forms\auth\LoginForm;

class AuthController extends Controller
{
    private $service;

    public function __construct($id, $module, AuthService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/client/default/index']);
        }

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $client = $this->service->auth($form);
                Yii::$app->user->login(new Identity($client), $form->rememberMe ? Yii::$app->params['client.rememberMeDuration'] : 0);
                return $this->goBack(['/client/default/index']);
            } catch (InactiveException $e) {
                return $this->redirect(['auth/signup/activate', 'email' => $e->client->email]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('login', [
            'model' => $form,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
