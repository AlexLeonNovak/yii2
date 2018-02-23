<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\users\models\UsersGroup */

$this->title = 'Update Users Group: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Users Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
