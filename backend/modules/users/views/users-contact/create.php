<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\users\models\UsersContact */

$this->title = 'Создать контакт';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['/users/user/index']];
$this->params['breadcrumbs'][] = [
            'label' => $model->user->lastName ? $model->user->fullNameInitials : $model->user->username, 
            'url' => ['/users/user/view', 'id' => $model->id_user]
        ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-contact-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
