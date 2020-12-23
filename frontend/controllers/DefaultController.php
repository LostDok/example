<?php

namespace modules\client\frontend\controllers;

use modules\client\common\models\Client;
use modules\client\common\models\Organization;
use modules\client\frontend\helpers\ProfileTabs;
use modules\client\src\forms\profile\ClientSecurity;
use modules\client\src\forms\profile\ProductInfo;
use modules\client\src\useCases\ProfileService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    private ProfileService $service;

    public function __construct($id, $module, ProfileService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = $this->findModel(Yii::$app->user->getId());

        return $this->render('index', [
            'client' => $model,
            'info' => $model->info,
            'security' => new ClientSecurity($model),
            'organization' => $model->info->organization ?: new Organization(),
        ]);
    }

    public function actionUpdateInfo()
    {
        $model = $this->findModel(Yii::$app->user->getId());

        $info = $model->info;

        if ($info->load(Yii::$app->request->post()) && $info->save()) {
            Yii::$app->session->setFlash('success', 'Информация успешно сохранена.');
            return $this->redirect(['index', '#' => ProfileTabs::TAB_INFO]);
        }

        return $this->render('index', [
            'tab' => ProfileTabs::TAB_INFO,
            'client' => $model,
            'info' => $info,
            'security' => new ClientSecurity($model),
            'organization' => $info->organization ?: new Organization(),
        ]);
    }

    public function actionUpdateSecurity()
    {
        $model = $this->findModel(Yii::$app->user->getId());

        $security = new ClientSecurity($model);

        if ($security->load(Yii::$app->request->post()) && $security->validate()) {
            try {
                $this->service->updateSecurity(Yii::$app->user->getId(), $security);
                Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');
                return $this->redirect(['index', '#' => ProfileTabs::TAB_SECURITY]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('index', [
            'tab' => ProfileTabs::TAB_SECURITY,
            'client' => $model,
            'info' => $model->info,
            'security' => $security,
            'organization' => $model->info->organization ?: new Organization(),
        ]);
    }

    public function actionSaveOrganization()
    {
        $model = $this->findModel(Yii::$app->user->getId());

        $organization = $model->info->organization ?: new Organization(['owner_id' => $model->id]);

        if ($organization->load(Yii::$app->request->post()) && $organization->save()) {
            if (!$model->info->organization_id) {
                $model->info->organization_id = $organization->id;
                $model->info->save(false, ['organization_id']);
            }
            Yii::$app->session->setFlash('success', 'Организация успешно сохранена.');
            return $this->redirect(['index', '#' => ProfileTabs::TAB_ORGANIZATION]);
        }

        return $this->render('index', [
            'tab' => ProfileTabs::TAB_ORGANIZATION,
            'client' => $model,
            'info' => $model->info,
            'security' => new ClientSecurity($model),
            'organization' => $organization,
        ]);
    }

    public function actionProductInfo()
    {
        $client = $this->findModel(Yii::$app->user->getId());

        $model = new ProductInfo($client);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $this->service->setProductInfo($client->id, $model);
                Yii::$app->session->setFlash('success', 'Информация успешно сохранена.');
                return $this->goBack(Yii::$app->homeUrl);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('product-info', [
            'client' => $client,
            'model' => $model,
        ]);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Пользователь не найден.');
    }
}