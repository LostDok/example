<?php

/* @var $this yii\web\View */
/* @var $email string */

use frontend\widgets\activeForm\ActiveBigForm;
use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Активация';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="b-section">
    <div class="b-section__container">
        <div class="b-auth-block">
            <div class="b-auth-block__title b-auth-block__title_c-dark b-auth-block__title_ta-center">
                Активация
            </div>
            <?php $form = ActiveBigForm::begin(['id' => 'form-signup', 'options' => ['class' => 'b-big-form b-auth-block__form']]); ?>
            <div class="b-big-form__row b-big-form__row_jc-center">
                <div class="b-col b-col_12 b-big-form__col">
                    <div class="b-big-form__text b-big-form__text_ta-center b-big-form__text_c-dark">
                        Мы отправили вам письмо со ссылкой для активации вашего профиля на <?= $email ?>. Перейдите по ссылке из письма, чтобы продолжить работу.
                    </div>
                </div>
                <div class="b-col b-col_7 b-col_xs-12 b-big-form__col">
                    <button type="submit"
                            class="b-button b-button_w-100 b-button_bgc-primary b-button_c-dark b-big-form__button">
                        Отправить еще раз
                    </button>
                </div>
            </div>
            <?php ActiveBigForm::end(); ?>
        </div>
    </div>
</section>