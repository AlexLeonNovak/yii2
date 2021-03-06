<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Редактирование данных о сотруднике';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
            'label' => $model->lastName ? $model->fullNameInitials : $model->username,
            'url' => ['view', 'id' => $model->id]
        ];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'group' => $group,
    ]) ?>

</div>
