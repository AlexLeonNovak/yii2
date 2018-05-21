<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->lastName ? $model->fullNameInitials : $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-6">
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
                ],
            ])
            ?>
        </div>
        <div class="col-md-6">
            <p>
            <?= Html::a('Добавить контакт', ['/users/users-contact/create', 'id_user' => $model->id], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
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
        </div>
    </div>
</div>
