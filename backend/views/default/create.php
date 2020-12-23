<?php

use common\adminLTE\widgets\fileinput\DeletableImageInput;
use modules\client\common\enums\Gender;
use modules\client\common\models\ClientInfo;
use modules\client\common\models\ClientWorkLine;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model \modules\client\backend\models\ClientCreateForm */
/* @var $form yii\bootstrap4\ActiveForm */

$this->title = 'Создать клиента';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Создать';
?>
<div class="client-create">

    <div class="card">

        <?php $form = ActiveForm::begin(); ?>

        <div class="card-header">
            <div class="float-right">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <div class="card-body">

            <?= $form->errorSummary($model) ?>

            <?= $this->render('_auth', [
                'form' => $form,
                'auth' => $model->auth,
            ]) ?>

            <hr>
            <h2>Информация</h2>

            <?= $this->render('_info', [
                'form' => $form,
                'info' => $model->info,
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
