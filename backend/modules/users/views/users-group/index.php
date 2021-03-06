<?php

use yii\bootstrap\Html;
use yii\widgets\ListView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\users\models\UsersGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Должности сотрудников';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['/users/user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить должность', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-condensed'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
