<?php

use borales\extensions\phoneInput\PhoneInput;
use common\adminLTE\widgets\fileinput\DeletableImageInput;
use frontend\widgets\activeForm\ActiveBigForm;
use frontend\widgets\activeForm\ActiveImageInputField;
use modules\client\common\models\OrganizationWorkLine;
use modules\client\frontend\helpers\ClientHelper;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $form \frontend\widgets\activeForm\ActiveBigForm
 * @var $organization \modules\client\common\models\Organization
 */

?>

<?php $form = ActiveBigForm::begin(['action' => ['save-organization'], 'options' => ['class' => 'b-profile-form']]); ?>
    <div class="b-profile-form__row b-profile-form__row_jc-center">
        <div class="b-col_3 b-col_md-6 b-profile-form__col">
            <?= $form->field($organization, 'photo', ['class' => ActiveImageInputField::class])
                ->label('Загрузить фото')
                ->imageInput(ClientHelper::getOrganizationPreviewUrl($organization)) ?>
        </div>
        <div class="b-col_9 b-col_md-12 b-profile-form__col">
            <div class="b-profile-form__row">
                <div class="b-col_12 b-profile-form__col">
                    <?= $form->field($organization, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="b-col_6  b-col_md-12 b-profile-form__col">
                    <?= $form->field($organization, 'email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="b-col_6 b-col_md-12 b-profile-form__col">
                    <?= $form->field($organization, 'phone')->widget(PhoneInput::class, [
                        'jsOptions' => [
                            'preferredCountries' => ['ru', 'ua'],
                        ]
                    ]) ?>
                </div>
                <div class="b-col_6 b-col_md-12 b-profile-form__col">
                    <?= $form->field($organization, 'work_line_id')->dropDownList(OrganizationWorkLine::getMap(), ['prompt' => 'Не указан']) ?>
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
