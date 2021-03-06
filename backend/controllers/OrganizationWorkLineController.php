<?php

namespace modules\client\backend\controllers;

use Yii;
use modules\client\common\models\OrganizationWorkLine;
use modules\client\backend\models\OrganizationWorkLineSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrganizationWorkLineController implements the CRUD actions for OrganizationWorkLine model.
 */
class OrganizationWorkLineController extends Controller
{
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
     * Lists all OrganizationWorkLine models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrganizationWorkLineSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new OrganizationWorkLine model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrganizationWorkLine();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись успешно создана.');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OrganizationWorkLine model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись успешно сохранена.');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OrganizationWorkLine model.
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
     * Finds the OrganizationWorkLine model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrganizationWorkLine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrganizationWorkLine::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModels($ids)
    {
        if (($models = OrganizationWorkLine::findAll($ids)) !== null) {
            return $models;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
