<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\users\models\UsersGroup;
use yii\helpers\ArrayHelper;

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
        <?= Html::a('Зарегистрировать нового сотрудника', ['signup'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',

            [
                'attribute' => 'id_group',
               // 'value' => $model->usersGroup,
                'filter' => ArrayHelper::map(UsersGroup::find()->select(['name', 'id'])->groupBy('id')->all(), 'id', 'name'),
                'value' => 'usersGroup.name',
                
            ],
            [
                'attribute' => 'status',
                'value' => 'status'
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
