<?php

use borales\extensions\phoneInput\PhoneInput;
use common\adminLTE\widgets\fileinput\DeletableImageInput;
use modules\client\common\models\OrganizationWorkLine;
use yii\bootstrap4\Html;

/**
 * @var $this \yii\web\View
 * @var $form \yii\bootstrap4\ActiveForm
 * @var $organization \modules\client\common\models\Organization
 */

?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($organization, 'photo')->widget(DeletableImageInput::class, [
            'deleteAttribute' => 'deletePhoto',
        ]) ?>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($organization, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($organization, 'work_line_id')->dropDownList(OrganizationWorkLine::getMap(), ['prompt' => 'Не указан']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($organization, 'email')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= Html::activeLabel($organization, 'phone') ?>
                <?= $form->field($organization, 'phone')->label(false)->widget(PhoneInput::class, [
                    'jsOptions' => [
                        'preferredCountries' => ['ru', 'ua'],
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</div>
