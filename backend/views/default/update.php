<?php

use modules\client\common\models\ClientInfo;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $info ClientInfo */
/* @var $auth \modules\client\backend\models\ClientAuth */
/* @var $organization \modules\client\common\models\Organization */

$this->title = 'Редактировать клиента: #' . $info->client_id;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="client-update">

    <div class="card">

        <?php $form = ActiveForm::begin(['action' => ['update-auth', 'id' => $info->client_id]]); ?>

        <div class="card-header">
            <div class="float-left">
                <h2>Аутентификация</h2>
            </div>
        </div>

        <div class="card-body">

            <?= $form->errorSummary($auth) ?>

            <?= $this->render('_auth', [
                'form' => $form,
                'auth' => $auth,
            ]) ?>

        </div>

        <div class="card-footer">
            <div class="float-right">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="card">

        <?php $form = ActiveForm::begin(['action' => ['update-info', 'id' => $info->client_id]]); ?>

        <div class="card-header">
            <div class="float-left">
                <h2>Информация</h2>
            </div>
        </div>

        <div class="card-body">

            <?= $form->errorSummary($info) ?>

            <?= $this->render('_info', [
                'form' => $form,
                'info' => $info,
            ]) ?>

        </div>

        <div class="card-footer">
            <div class="float-right">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="card">

        <?php $form = ActiveForm::begin(['action' => ['save-organization', 'id' => $info->client_id]]); ?>

        <div class="card-header">
            <div class="float-left">
                <h2>Организация</h2>
            </div>
        </div>

        <div class="card-body">

            <?= $form->errorSummary($organization) ?>

            <?= $this->render('_organization', [
                'form' => $form,
                'organization' => $organization,
            ]) ?>

        </div>

        <div class="card-footer">
            <div class="float-right">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
