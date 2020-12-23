<?php

use borales\extensions\phoneInput\PhoneInput;
use common\adminLTE\widgets\fileinput\DeletableImageInput;
use frontend\widgets\activeForm\ActiveBigForm;
use frontend\widgets\activeForm\ActiveImageInputField;
use modules\client\common\enums\Gender;
use modules\client\common\models\ClientInfo;
use modules\client\common\models\ClientWorkLine;
use modules\client\frontend\helpers\ClientHelper;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $email string
 * @var $info ClientInfo
 * @var $form \frontend\widgets\activeForm\ActiveBigForm
 */
?>
<?php $form = ActiveBigForm::begin(['action' => ['update-info'], 'options' => ['class' => 'b-profile-form', 'enctype' => 'multipart/form-data']]); ?>

    <div class="b-profile-form__row b-profile-form__row_jc-center">
        <div class="b-col_3 b-col_md-6 b-profile-form__col">
            <?= $form->field($info, 'photo', ['class' => ActiveImageInputField::class])
                ->label('Загрузить фото')
                ->imageInput(ClientHelper::getPreviewUrl($info)) ?>
        </div>
        <div class="b-col_9 b-col_md-12 b-profile-form__col">
            <div class="b-profile-form__row">
                <div class="b-col_6 b-col_md-12 b-profile-form__col">
                    <?= $form->field($info, 'name')->textInput() ?>
                </div>
                <div class="b-col_6 b-col_md-12 b-profile-form__col">
                    <?= $form->field($info, 'surname')->textInput() ?>
                </div>
                <div class="b-col_6 b-col_md-12 b-profile-form__col">
                    <?= $form->field($info, 'username')->textInput() ?>
                </div>
                <div class="b-col_6 b-col_md-12 b-profile-form__col">
                    <?= $form->field($info, 'display_type')->dropDownList(ClientInfo::getDisplayTypeMap()) ?>
                </div>
                <div class="b-col_6 b-col_md-12 b-profile-form__col">
                    <label class="b-main-field b-main-field_disabled b-profile-form__field">
                        <div class="b-main-field__label b-main-field__label_c-gray-l">
                            Email
                        </div>
                        <input type="text" class="b-main-field__input" value="<?= $email ?>" readonly>
                    </label>
                </div>
                <div class="b-col_6 b-col_md-12 b-profile-form__col">
                    <?= $form->field($info, 'phone')->widget(PhoneInput::class, [
                        'jsOptions' => [
                            'preferredCountries' => ['ru', 'ua'],
                        ]
                    ]) ?>
                </div>
                <div class="b-col_6 b-col_md-12 b-profile-form__col">
                    <?= $form->field($info, 'gender')->dropDownList(Gender::$list, ['prompt' => 'Не указан']) ?>
                </div>
                <div class="b-col_6 b-col_md-12 b-profile-form__col">
                    <?= $form->field($info, 'birth_date')->textInput(['type' => 'date']) ?>
                </div>
                <div class="b-col_6 b-col_md-12 b-profile-form__col">
                    <?= $form->field($info, 'work_line_id')->dropDownList(ClientWorkLine::getMap(), ['prompt' => 'Не указан']) ?>
                </div>
                <div class="b-col_6 b-col_d-md-none b-profile-form__col"></div>
                <div class="b-col_3  b-col_md-6 b-col_xs-12 b-profile-form__col">
                    <button type="submit"
                            class="b-button b-button_c-dark b-button_bgc-primary b-button_w-100 b-button_fz-small b-button_ff-2">
                        Применить
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php ActiveBigForm::end(); ?>