<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Answers */

$this->title = 'Редактировать ответы';
$this->params['breadcrumbs'][] = Yii::$app->session['breadcrumbs-themes'];
$this->params['breadcrumbs'][] = Yii::$app->session['breadcrumbs-test'];
$this->params['breadcrumbs'][] = Yii::$app->session['breadcrumbs-question'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'models' => $models,
        'result' => $result,
    ]) ?>

</div>
