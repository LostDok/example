<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model modules\client\common\models\ClientWorkLine */

$this->title = 'Редактировать род деятельности клиентов: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Роды деятельности клиентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="client-work-line-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
