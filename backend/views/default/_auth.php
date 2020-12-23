<?php

/**
 * @var $this \yii\web\View
 * @var $form \yii\bootstrap4\ActiveForm
 * @var $auth \modules\client\backend\models\ClientAuth
 */
?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($auth, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($auth, 'password')->passwordInput() ?>
    </div>
</div>
