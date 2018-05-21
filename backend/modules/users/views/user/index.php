<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\users\models\UsersGroup;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\users\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\User */

$this->title = 'Сотрудники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Зарегистрировать нового сотрудника', ['signup'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('Должности сотрудников', ['/users/users-group/index'], ['class' => 'btn btn-primary']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'fullName',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->lastName ? $model->fullName :
                            '<span class="text-danger"><i>(Не указано)</i></span>', 
                            Url::to(['view', 'id' => $model->id]));
                }
            ],
            [
                'attribute' => 'username',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->username,Url::to(['view', 'id' => $model->id]));
                }
            ],
            'email:email',
            [
                'attribute' => 'id_group',
                'filter' => ArrayHelper::map(UsersGroup::find()->select(['name', 'id'])->groupBy('id')->all(), 'id', 'name'),
                'value' => 'usersGroup.name',
            ],
            [
                'attribute' => 'dateOfBirth',
                'format' => ['Datetime', 'php:d.m.Y'],
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model) {
                        if ($model->status === $model::STATUS_ACTIVE){
                            return '<span class="glyphicon glyphicon-ok text-success"></span>';
                        } else {
                            return '<span class="glyphicon glyphicon-remove text-danger"></span>';
                        }
                    },
                'filter' => Html::activeDropDownList($searchModel, 'status', [
                    '0' => 'Неактивный',
                    '10' => 'Активный',
                ],['class'=>'form-control', 'prompt' => 'Все']),
                'contentOptions' => [
                    'class' => 'col-sm-1',
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'template' => '{view} {update} {active}',
                'buttons' => [
                    'active' => function($url, $model){
                        return Html::a('<span class="label label-primary"><span class="glyphicon glyphicon-ok-sign"></span>'
                                . ' <span class="glyphicon glyphicon-remove-sign"></span></span>',
                                Url::to(['activate', 'id' => $model->id]),
                                ['title' => 'Активация/деактивация']
                                );
                    },
                ],
                'contentOptions' => [
                    'class' => 'col-sm-1',
                ],
            ],
        ],
    ]); ?>
</div>
