<?php

/**
 * @var $this \yii\web\View
 * @var $form \frontend\widgets\activeForm\ActiveBigForm
 * @var $security \modules\client\src\forms\profile\ClientSecurity
 */

use frontend\widgets\activeForm\ActiveBigForm; ?>
<?php $form = ActiveBigForm::begin(['action' => ['update-security'], 'options' => ['class' => 'b-profile-form']]); ?>
<div class="b-profile-form__row">
    <div class="b-col_9 b-col_md-12 b-profile-form__col">
        <div class="b-profile-form__row">
            <div class="b-col_6  b-col_md-12 b-profile-form__col">
                <?= $form->field($security, 'oldPassword')->passwordInput() ?>
            </div>
            <div class="b-col_6  b-col_d-md-none b-profile-form__col">
            </div>
            <div class="b-col_6  b-col_md-12 b-profile-form__col">
                <?= $form->field($security, 'newPassword')->passwordInput() ?>
            </div>
            <div class="b-col_6  b-col_md-12 b-profile-form__col">
                <?= $form->field($security, 'newPassword2')->passwordInput() ?>
            </div>
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
