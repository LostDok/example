<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \modules\client\src\forms\auth\LoginForm */

use frontend\widgets\activeForm\ActiveBigForm;
use yii\helpers\Html;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="b-section">
    <div class="b-section__container">
        <div class="b-auth-block">
            <div class="b-auth-block__title b-auth-block__title_c-dark b-auth-block__title_ta-center">
                Вход
            </div>
            <?php $form = ActiveBigForm::begin(['id' => 'login-form', 'options' => ['class' => 'b-big-form b-auth-block__form']]); ?>
            <div class="b-big-form__row b-big-form__row_jc-center">
                <div class="b-col b-col_12 b-big-form__col">
                    <?= $form->field($model, 'email')->textInput() ?>
                </div>
                <div class="b-col b-col_12 b-big-form__col">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
                <div class="b-col b-col_12 b-big-form__col">
                    <?= Html::a('Забыли пароль?', ['auth/reset/request'], ['class' => 'b-big-form__link b-big-form__link_d-block b-big-form__link_ta-right b-big-form__link_c-info b-big-form__link_sm']) ?>
                </div>
                <div class="b-col b-col_7 b-col_xs-12 b-big-form__col">
                    <button type="submit"
                            class="b-button b-button_w-100 b-button_bgc-primary b-button_c-dark b-big-form__button">
                        Войти
                    </button>
                </div>
                <div class="b-col b-col_7 b-col_xs-12 b-col_ta-center b-big-form__col">
                    <?= Html::a('Зарегистрироваться', ['auth/signup/request'], ['class' => 'b-big-form__link  b-big-form__link_c-info']) ?>
                </div>
            </div>
            <?php ActiveBigForm::end(); ?>
            <? /*= yii\authclient\widgets\AuthChoice::widget([
                            'baseAuthUrl' => ['auth/network/auth']
                        ]); */ ?>
        </div>
    </div>
</section>



