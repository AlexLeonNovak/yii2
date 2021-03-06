<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Themes */

$this->title = 'Редактировать название темы';
$this->params['breadcrumbs'][] = ['label' => 'Список тем тестов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'groups' => $groups,
    ]) ?>

</div>
