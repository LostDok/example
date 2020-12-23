<?php

use borales\extensions\phoneInput\PhoneInput;
use frontend\widgets\activeForm\ActiveBigForm;
use modules\client\common\models\ClientWorkLine;

/**
 * @var $this \yii\web\View
 * @var $model \modules\client\src\forms\profile\ProductInfo
 * @var $form \frontend\widgets\activeForm\ActiveBigForm
 */

?>
<section class="b-section">
    <div class="b-section__container">
        <div class="b-auth-block">
            <div class="b-auth-block__title b-auth-block__title_c-dark b-auth-block__title_ta-center">
                Добро пожаловать!
                <div class="b-auth-block__subtitle">
                    Завершите регистрацию и начните ваш расчет
                </div>
            </div>
            <?php $form = ActiveBigForm::begin(['options' => ['class' => 'b-big-form b-auth-block__form']]); ?>
            <div class="b-big-form__row">
                <div class="b-col b-col_6 b-col_sm-12 b-big-form__col">
                    <?= $form->field($model, 'name') ?>
                </div>
                <div class="b-col b-col_6 b-col_sm-12 b-big-form__col">
                    <?= $form->field($model, 'surname') ?>
                </div>
                <div class="b-col b-col_6 b-col_sm-12 b-big-form__col">
                    <?= $form->field($model, 'workLineId')->dropDownList(ClientWorkLine::getMap()) ?>
                </div>
                <div class="b-col b-col_6 b-col_sm-12 b-big-form__col">
                    <?= $form->field($model, 'phone')->widget(PhoneInput::class, [
                        'jsOptions' => [
                            'preferredCountries' => ['ru', 'ua'],
                        ]
                    ]) ?>
                </div>
                <div class="b-col b-col_12 b-big-form__col">
                    <div class="b-big-form__subtitle  b-big-form__subtitle_c-dark">
                        Карта
                    </div>
                </div>
                <div class="b-col b-col_12 b-big-form__col">
                    <?= $form->field($model, 'cardName') ?>
                </div>
                <div class="b-col b-col_8 b-big-form__col">
                    <?= $form->field($model, 'cardNumber')->textInput(['placeholder' => 'XXXX-XXXX-XXXX-XXXX']) ?>
                </div>
                <div class="b-col b-col_4 b-big-form__col">
                    <?= $form->field($model, 'cvc')->textInput(['placeholder' => 'XXX', 'maxlength' => true]) ?>
                </div>
                <div class="b-col b-col_7 b-col_xs-12 b-big-form__col">
                    <button type="submit"
                            class="b-button b-button_w-100 b-button_bgc-primary b-button_c-dark b-big-form__button">
                        ОК
                    </button>
                </div>
            </div>
            <?php ActiveBigForm::end(); ?>
        </div>
    </div>
</section>

