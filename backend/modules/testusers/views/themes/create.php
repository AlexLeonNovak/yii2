<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Themes */

$this->title = 'Create Themes';
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
