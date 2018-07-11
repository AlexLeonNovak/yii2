<?php

use yii\bootstrap\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\users\models\UsersInfo */

$this->title = 'Добавить информацию';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['/users/user/index']];
$this->params['breadcrumbs'][] = [
            'label' => $model->user->fullName, 
            'url' => ['/users/user/view', 'id' => $model->id_user]
        ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
