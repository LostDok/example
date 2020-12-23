<?php

namespace modules\client\backend\controllers;

use modules\client\backend\models\ClientAuth;
use modules\client\backend\models\ClientCreateForm;
use modules\client\common\models\Organization;
use modules\client\src\useCases\ClientManageService;
use Yii;
use modules\client\common\models\Client;
use modules\client\backend\models\ClientSearch;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Client model.
 */
class DefaultController extends Controller
{
    private ClientManageService $service;

    public function __construct($id, $module, ClientManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'multiple-delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new ClientCreateForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $client = $this->service->create($model);
                Yii::$app->session->setFlash('success', 'Клиент успешно создан.');
                return $this->redirect(['update', 'id' => $client->id]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        return $this->render('update', [
            'info' => $model->info,
            'auth' => new ClientAuth($model),
            'organization' => $model->info->organization ?: new Organization(),
        ]);
    }

    public function actionUpdateInfo($id)
    {
        $model = $this->findModel($id);

        $info = $model->info;

        if ($info->load(Yii::$app->request->post()) && $info->save()) {
            Yii::$app->session->setFlash('success', 'Информация успешно обновлена.');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'info' => $info,
            'auth' => new ClientAuth($model),
            'organization' => $info->organization ?: new Organization(),
        ]);
    }

    public function actionUpdateAuth($id)
    {
        $model = $this->findModel($id);

        $auth = new ClientAuth($model);

        if ($auth->load(Yii::$app->request->post()) && $auth->validate()) {
            try {
                $this->service->updateAuth($id, $auth);
                Yii::$app->session->setFlash('success', 'Успешно обновлено.');
                return $this->redirect(['update', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'info' => $model->info,
            'auth' => $auth,
            'organization' => $model->info->organization ?: new Organization(),
        ]);
    }

    public function actionSaveOrganization($id)
    {
        $model = $this->findModel($id);

        $organization = $model->info->organization ?: new Organization(['owner_id' => $model->id]);

        if ($organization->load(Yii::$app->request->post()) && $organization->save()) {
            if (!$model->info->organization_id) {
                $model->info->organization_id = $organization->id;
                $model->info->save(false, ['organization_id']);
            }
            Yii::$app->session->setFlash('success', 'Организация успешно сохранена.');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'info' => $model->info,
            'auth' => new ClientAuth($model),
            'organization' => $organization,
        ]);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Запись успешно удалена.');
        }
        return $this->redirect(['index']);
    }

    public function actionMultipleDelete()
    {
        if (!Yii::$app->request->post('ids')) {
            throw new BadRequestHttpException('Missing required parameters: ids');
        }
        $number = 0;
        $models = $this->findModels(Yii::$app->request->post('ids'));
        foreach ($models as $model) {
            $number += $model->delete();
        }
        if (count($models) === $number) {
            Yii::$app->session->setFlash('success', 'Выбранные записи успешно удалены.');
        }
        return $this->redirect(['index']);
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

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModels($ids)
    {
        if (($models = Client::findAll($ids)) !== null) {
            return $models;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
