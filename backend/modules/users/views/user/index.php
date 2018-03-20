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
            'status',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
