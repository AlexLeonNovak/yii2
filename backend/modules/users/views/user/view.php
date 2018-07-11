<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить этого сотрудника?',
                        'method' => 'post',
                    ],
                ])
                ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <h3>Основная информация</h3>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'fullName',
                    [
                        'attribute' => 'dateOfBirth',
                        'format' => 'date',
                    ],
                    
                    'usersGroup.name',
                    'username',
                    'email:email',
                    [
                        'attribute' => 'status',
                        'value' => $model->status == $model::STATUS_ACTIVE ? 'Активный' : 'Неактивен',
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                    [
                        'format' => 'raw',
                        'value' => $model->worktime_start ? (Yii::$app->formatter->asTime($model->worktime_start, 'php:H:i') 
                            . ' - ' . Yii::$app->formatter->asTime($model->worktime_end, 'php:H:i')) : '<span class="not-set">(не задано)</span>',
                        'label' => 'Рабочее время',
                    ],
                ],
            ])
            ?>
        </div>
        <div class="col-md-6">
            <h3>Контакты</h3>
            <?=
            GridView::widget([
                'dataProvider' => $dataProviderContact,
                'columns' => [
                    // ['class' => 'yii\grid\SerialColumn'],
                    //'id_user',
                    'type',
                    'value',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => '/users/users-contact',
                        'header' => 'Действия',
                        'template' => '{update} {delete}',
                    ],
                ],
            ]);
            ?>
            <p>
            <?= Html::a('Добавить контакт', ['/users/users-contact/create', 'id_user' => $model->id], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>
    <div>
        <h3>Дополнительная информация</h3>
        <?=
            GridView::widget([
                'dataProvider' => $dataProviderInfo,
                'columns' => [
                    // ['class' => 'yii\grid\SerialColumn'],
                    //'id_user',
                    [
                        'attribute' => 'type',
                        'contentOptions' => [
                            'class' => 'col-sm-3',
                        ],
                    ],
                    'value',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => '/users/users-info',
                        'header' => 'Действия',
                        'template' => '{update} {delete}',
                        'contentOptions' => [
                            'class' => 'col-sm-1',
                        ],
                    ],
                ],
            ]);
            ?>
            <p>
            <?= Html::a('Добавить информацию', ['/users/users-info/create', 'id_user' => $model->id], ['class' => 'btn btn-success']) ?>
            </p>
    </div>
</div>
