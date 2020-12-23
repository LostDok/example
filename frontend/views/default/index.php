<?php

use modules\client\frontend\helpers\ProfileTabs;

/**
 * @var $this \yii\web\View
 * @var $tab string|null
 * @var $client \modules\client\common\models\Client
 * @var $info \modules\client\common\models\ClientInfo
 * @var $organization \modules\client\common\models\Organization
 * @var $security \modules\client\src\forms\profile\ClientSecurity
 */

$profileTabsPositionsJson = json_encode(ProfileTabs::getPositions());
$js = <<<JS
let profileTab = '$tab';
let profileTabsPositions = $profileTabsPositionsJson;
let profileTabsConfig = {
    name: 'profile-tabs'
};
if (profileTab && profileTabsPositions.hasOwnProperty(profileTab)) {
    profileTabsConfig['startPosition'] = profileTabsPositions[profileTab];
} else if (window.location.hash && profileTabsPositions.hasOwnProperty(window.location.hash.replace(/^#/, '')))  {
    profileTabsConfig['startPosition'] = profileTabsPositions[window.location.hash.replace(/^#/, '')];
}
new ProfileTabs(profileTabsConfig);
JS;
$this->registerJs($js);
 ?>
<section class="b-section">
    <div class="b-section__container">
        <div class="b-general-box">
            <div class="b-general-box__row">
                <div class="b-col b-col_3 b-col_d-sm-none b-general-box__col">
                    <aside class="b-aside b-general-box__aside">
                        <div class="b-aside__list">
                            <div class="b-aside__item" data-tabs-trigger="profile-tabs">
                                <div class="b-icon b-icon_md  b-icon_c-dark b-aside__item-icon">
                                    <i></i>
                                </div>
                                <div class="b-aside__item-title">
                                    Информация
                                </div>
                            </div>
                            <div class="b-aside__item" data-tabs-trigger="profile-tabs">
                                <div class="b-icon b-icon_md  b-icon_c-dark b-aside__item-icon">
                                    <i></i>
                                </div>
                                <div class="b-aside__item-title">
                                    Мой тариф и платежи
                                </div>
                            </div>
                            <div class="b-aside__item" data-tabs-trigger="profile-tabs">
                                <div class="b-icon b-icon_md  b-icon_c-dark b-aside__item-icon">
                                    <i></i>
                                </div>
                                <div class="b-aside__item-title">
                                    Организация
                                </div>
                            </div>
                            <div class="b-aside__item" data-tabs-trigger="profile-tabs">
                                <div class="b-icon b-icon_md  b-icon_c-dark b-aside__item-icon">
                                    <i></i>
                                </div>
                                <div class="b-aside__item-title">
                                    Безопасность
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="b-col b-col_9 b-col_sm-12 b-general-box__col" data-tabs-content="profile-tabs">
                    <div class="b-general-box__header">
                        <div class="b-general-box__title b-general-box__title_c-dark">
                            Информация
                        </div>
                    </div>

                    <div class="b-general-box__main b-general-box__main_shadow">
                        <?= $this->render('_info', [
                            'email' => $client->email,
                            'info' => $info,
                        ]) ?>
                    </div>
                </div>
                <div class="b-col b-col_9 b-col_sm-12 b-general-box__col" data-tabs-content="profile-tabs">
                    <div class="b-general-box__header">
                        <div class="b-general-box__title b-general-box__title_c-dark">
                            Мой тариф платежи
                        </div>
                    </div>

                    <div class="b-general-box__main b-general-box__main_shadow">
                        <div class="b-calc-table b-general-box__block">
                            <div class="b-calc-table__header b-calc-table__header_bgc-light">
                                <div class="b-calc-table__title b-calc-table__title_c-dark">
                                    Мой тариф
                                </div>
                            </div>
                            <div class="b-calc-table__main">
                                <div class="b-table-second b-calc-table__block-second">
                                    <div class="b-icon b-icon_bgc-dark b-icon_md b-icon_round b-icon_f-primary b-table-second__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24"
                                             height="24" viewBox="0 0 24 24">
                                            <path d="M10,2H14C15.1,2 16,2.9 16,4V6H20C21.1,6 22,6.9 22,8V19C22,20.1 21.1,21 20,21H4C2.89,21 2,20.1 2,19V8C2,6.89 2.89,6 4,6H8V4C8,2.89 8.89,2 10,2M14,6V4H10V6H14Z"/>
                                        </svg>
                                    </div>
                                    <div class="b-table-second__content b-table-second__content_desc">
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            <strong>Профессиональный</strong>
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            4,990 ₽/мес
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_ml-auto b-table-second__text_f-dark">
                                            <div class="b-icon b-icon_md  b-icon_c-dark b-aside__item-icon"
                                                 title="Информация о тарифе">
                                                <i></i>
                                            </div>
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_c-gray-l">
                                            Поменять
                                        </div>
                                    </div>
                                    <div class="b-table-second__content b-table-second__content_mob">
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            <strong>Профессиональный</strong>
                                            <br> 4,990 ₽/мес
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_d-flex b-table-second__text_ai-center b-table-second__text_jc-end b-table-second__text_ml-auto b-table-second__text__c-gray-l">
                                            <div class="b-icon b-icon_md  b-icon_c-gray-l" title="Информация о тарифе">
                                                <i></i>
                                            </div>
                                            Поменять
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="b-calc-table b-general-box__block">
                            <div class="b-calc-table__header b-calc-table__header_bgc-light">
                                <div class="b-calc-table__title b-calc-table__title_c-dark">
                                    Метод оплаты
                                </div>
                            </div>
                            <div class="b-calc-table__main">
                                <div class="b-table-second b-calc-table__block-second">
                                    <div class="b-icon b-icon_bgc-dark b-icon_md b-icon_round b-icon_f-primary b-table-second__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24"
                                             height="24" viewBox="0 0 24 24">
                                            <path d="M20,8H4V6H20M20,18H4V12H20M20,4H4C2.89,4 2,4.89 2,6V18C2,19.1 2.9,20 4,20H20C21.1,20 22,19.1 22,18V6C22,4.89 21.1,4 20,4Z"/>
                                        </svg>
                                    </div>
                                    <div class="b-table-second__content">
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            <strong>Карта ****5213</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="b-calc-table b-general-box__block">
                            <div class="b-calc-table__header b-calc-table__header_bgc-light">
                                <div class="b-calc-table__title b-calc-table__title_c-dark">
                                    Платежи
                                </div>
                                <div class="b-calc-table__search b-icon b-icon_lg b-icon_f-dark ">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         version="1.1" width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="b-calc-table__main">
                                <div class="b-table-second b-calc-table__block-second">
                                    <div class="b-icon b-icon_bgc-dark b-icon_md b-icon_round b-icon_f-primary b-table-second__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24"
                                             height="24" viewBox="0 0 24 24">
                                            <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"/>
                                        </svg>
                                    </div>
                                    <div class="b-table-second__content">
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            <strong>Оплата тарифа</strong>
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            Карта ****5213
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            12 Feb 2020, 10:00 MSK
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_ml-auto b-table-second__text_c-dark">
                                            1,000 ₽
                                        </div>
                                    </div>
                                </div>
                                <div class="b-table-second b-calc-table__block-second">
                                    <div class="b-icon b-icon_bgc-dark b-icon_md b-icon_round b-icon_f-primary b-table-second__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24"
                                             height="24" viewBox="0 0 24 24">
                                            <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"/>
                                        </svg>
                                    </div>
                                    <div class="b-table-second__content">
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            <strong>Оплата тарифа</strong>
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            Карта ****5213
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            12 Feb 2020, 10:00 MSK
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_ml-auto b-table-second__text_c-dark">
                                            1,000 ₽
                                        </div>
                                    </div>
                                </div>
                                <div class="b-table-second b-calc-table__block-second">
                                    <div class="b-icon b-icon_bgc-dark b-icon_md b-icon_round b-icon_f-primary b-table-second__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24"
                                             height="24" viewBox="0 0 24 24">
                                            <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"/>
                                        </svg>
                                    </div>
                                    <div class="b-table-second__content">
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            <strong>Оплата тарифа</strong>
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            Карта ****5213
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_c-dark">
                                            12 Feb 2020, 10:00 MSK
                                        </div>
                                        <div class="b-table-second__text b-table-second__text_ml-auto b-table-second__text_c-dark">
                                            1,000 ₽
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="b-col b-col_9 b-col_sm-12 b-general-box__col" data-tabs-content="profile-tabs">
                    <div class="b-general-box__header">
                        <div class="b-general-box__title b-general-box__title_c-dark">
                            Организация
                        </div>
                    </div>

                    <div class="b-general-box__main b-general-box__main_shadow">
                        <?= $this->render('_organization', [
                            'organization' => $organization,
                        ]) ?>
                    </div>
                </div>
                <div class="b-col b-col_9 b-col_sm-12 b-general-box__col" data-tabs-content="profile-tabs">
                    <div class="b-general-box__header">
                        <div class="b-general-box__title b-general-box__title_c-dark">
                            Безопасность
                        </div>
                    </div>

                    <div class="b-general-box__main b-general-box__main_shadow">
                        <?= $this->render('_security', [
                            'security' => $security,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>