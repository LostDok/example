<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model modules\client\common\models\OrganizationWorkLine */

$this->title = 'Редактировать род деятельности организаций: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Роды деятельности организаций', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="organization-work-line-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
