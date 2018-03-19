<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\testusers\models\TestSettings */

$this->title = 'Update Test Settings: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Test Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="test-settings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
