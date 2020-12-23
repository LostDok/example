<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model modules\client\common\models\ClientWorkLine */

$this->title = 'Создать род деятельности клиентов';
$this->params['breadcrumbs'][] = ['label' => 'Роды деятельности клиентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Создать';
?>
<div class="client-work-line-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
