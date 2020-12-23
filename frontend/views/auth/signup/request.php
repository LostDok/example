<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \modules\client\src\forms\auth\SignupForm */

use frontend\widgets\activeForm\ActiveBigForm;
use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="b-section">
    <div class="b-section__container">
        <div class="b-auth-block">
            <div class="b-auth-block__title b-auth-block__title_c-dark b-auth-block__title_ta-center">
                Регистрация
            </div>
            <?php $form = ActiveBigForm::begin(['id' => 'form-signup', 'options' => ['class' => 'b-big-form b-auth-block__form']]); ?>
            <div class="b-big-form__row b-big-form__row_jc-center">
                <div class="b-col b-col_12 b-big-form__col">
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                </div>
                <div class="b-col b-col_12 b-big-form__col">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
                <div class="b-col b-col_7 b-col_xs-12 b-big-form__col">
                    <button type="submit"
                            class="b-button b-button_w-100 b-button_bgc-primary b-button_c-dark b-big-form__button">
                        Зарегистрироваться
                    </button>
                </div>
                <div class="b-col b-col_7 b-col_ta-center b-col_xs-12 b-big-form__col">
                    <span>Уже есть аккаунт?</span>
                    <?= Html::a('Войти', ['auth/auth/login'], ['class' => 'b-big-form__link  b-big-form__link_c-info']) ?>
                </div>
            </div>
            <?php ActiveBigForm::end(); ?>
        </div>
    </div>
</section>