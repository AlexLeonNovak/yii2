<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\users\models\UsersContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список контактов';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['/users/user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-contact-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Создать контакт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id_user',
                'value' => 'user.fullName',
                'filter' => User::getUserListArray(),
            ],
            
            'type',
            'value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
