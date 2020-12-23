<?php

use borales\extensions\phoneInput\PhoneInput;
use common\adminLTE\widgets\fileinput\DeletableImageInput;
use modules\client\common\enums\Gender;
use modules\client\common\models\ClientInfo;
use modules\client\common\models\ClientWorkLine;
use yii\bootstrap4\Html;

/**
 * @var $this \yii\web\View
 * @var $info ClientInfo
 * @var $form \yii\bootstrap4\ActiveForm
 */
?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($info, 'photo')->widget(DeletableImageInput::class, [
            'deleteAttribute' => 'deletePhoto',
        ]) ?>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($info, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($info, 'surname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($info, 'username')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($info, 'display_type')->dropDownList(ClientInfo::getDisplayTypeMap()) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($info, 'work_line_id')->dropDownList(ClientWorkLine::getMap(), ['prompt' => 'Не указан']) ?>
            </div>
            <div class="col-md-6">
                <?= Html::activeLabel($info, 'phone') ?>
                <?= $form->field($info, 'phone')->label(false)->widget(PhoneInput::class, [
                    'jsOptions' => [
                        'preferredCountries' => ['ru', 'ua'],
                    ]
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($info, 'gender')->dropDownList(Gender::$list, ['prompt' => 'Не указан']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($info, 'birth_date')->textInput(['type' => 'date']) ?>
            </div>
        </div>
    </div>
</div>
