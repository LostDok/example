<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model modules\client\common\models\OrganizationWorkLine */

$this->title = 'Создать род деятельности организаций';
$this->params['breadcrumbs'][] = ['label' => 'Роды деятельности организаций', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Создать';
?>
<div class="organization-work-line-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
