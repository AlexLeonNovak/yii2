<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\users\models\UsersGroup */

$this->title = 'Create Users Group';
$this->params['breadcrumbs'][] = ['label' => 'Users Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
