<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\users\models\UsersGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Должности сотрудников';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить должность', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
        },
    ]); ?>
</div>
