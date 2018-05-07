<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\test */

$this->title = 'Создать тест';
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>