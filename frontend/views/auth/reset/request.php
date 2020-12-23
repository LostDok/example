<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \modules\client\src\forms\auth\PasswordResetRequestForm */

use frontend\widgets\activeForm\ActiveBigForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="b-section">
    <div class="b-section__container">
        <div class="b-auth-block">
            <div class="b-auth-block__title b-auth-block__title_c-dark b-auth-block__title_ta-center">
                Восcтановление пароля
            </div>
            <?php $form = ActiveBigForm::begin(['id' => 'reset-form', 'options' => ['class' => 'b-big-form b-auth-block__form']]); ?>
            <div class="b-big-form__row b-big-form__row_jc-center">
                <div class="b-col b-col_12 b-big-form__col">
                    <div class="b-big-form__text b-big-form__text_ta-center b-big-form__text_c-dark">
                        Введите ваш email. <br> Мы отправим вам ссылку для восстановления пароля.
                    </div>
                </div>
                <div class="b-col b-col_12 b-big-form__col">
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                </div>
                <div class="b-col b-col_7 b-col_xs-12 b-big-form__col">
                    <button type="submit"
                            class="b-button b-button_w-100 b-button_bgc-primary b-button_c-dark b-big-form__button">
                        Отправить
                    </button>
                </div>
                <div class="b-col b-col_7 b-col_ta-center b-col_xs-12 b-big-form__col">
                    <?= Html::a('Войти', ['auth/auth/login'], ['class' => 'b-big-form__link  b-big-form__link_c-info']) ?>
                </div>
            </div>
            <?php ActiveBigForm::end(); ?>
        </div>
    </div>
</section>