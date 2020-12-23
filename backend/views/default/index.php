<?php

use common\adminLTE\widgets\GridViewMultipleActionButton;
use modules\client\common\models\Client;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel modules\client\backend\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card client-index">

    <div class="card-header">
        <div class="float-left">
            <?= GridViewMultipleActionButton::widget(['gridId' => 'main-grid']) ?>
        </div>
        <div class="float-right">
            <?= Html::a('<i class="fas fa-user-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="card-body">

        <?= GridView::widget([
            'id' => 'main-grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => common\adminLTE\grid\CheckboxColumn::class],

                [
                    'attribute' => 'id',
                    'headerOptions' => ['style' => 'width:5%; white-space:nowrap;'],
                ],
                ['attribute' => 'fullName', 'label' => 'Имя', 'format' => 'raw', 'value' => function(Client $model) {
                    return Html::a($model->info->getFullName(), ['update', 'id' => $model->id]);
                }],
                'username:raw:Ник',
                'email:email:Email',
                [
                    'attribute' => 'status',
                    'label' => 'Статус',
                    'headerOptions' => ['style' => 'width:10%; white-space:nowrap;'],
                    'filter' => Client::$statuses,
                    'value' => function ($model) {
                        return Client::$statuses[$model->status];
                    }
                ],

                ['class' => common\adminLTE\grid\ActionColumn::class, 'headerOptions' => ['style' => 'width:5%; white-space:nowrap;'],],
            ],
        ]); ?>

    </div>

</div>
