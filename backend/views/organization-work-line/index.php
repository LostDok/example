<?php

use common\adminLTE\widgets\GridViewMultipleActionButton;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel modules\client\backend\models\OrganizationWorkLineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роды деятельности организаций';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card organization-work-line-index">

    <div class="card-header">
        <div class="float-left">
            <?= GridViewMultipleActionButton::widget(['gridId' => 'main-grid']) ?>
        </div>
        <div class="float-right">
            <?= Html::a('<i class="nav-icon fas fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card-body">

        <?= GridView::widget([
            'id' => 'main-grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => common\adminLTE\grid\CheckboxColumn::class],

                ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) {
                    return Html::a($model->name, ['update', 'id' => $model->id]);
                },],

                ['class' => common\adminLTE\grid\ActionColumn::class],
            ],
        ]); ?>

    </div>

</div>
