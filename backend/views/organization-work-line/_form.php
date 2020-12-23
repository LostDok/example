<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modules\client\common\models\OrganizationWorkLine */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="card organization-work-line-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-header">
        <div class="float-left">
            <?php if (!$model->isNewRecord) : ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
                ],
                ]) ?>
            <?php endif; ?>
        </div>
        <div class="float-right">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="card-body">

        <?= $form->errorSummary($model) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="card-footer">
        <div class="float-right">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
