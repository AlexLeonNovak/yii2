<?php

use yii\helpers\Html;
use backend\modules\testusers\models\Themes;

/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Test */

$this->title = 'Редактирование названия теста';
$this->params['breadcrumbs'][] = ['label' => 'Список тем тестов', 'url' => ['/testusers']];
$this->params['breadcrumbs'][] = [
        'label' => Themes::findOne(['id' => Yii::$app->request->get('id_theme')])->name,
        'url' => ['/testusers/test/index', 'id_theme' => Yii::$app->request->get('id_theme')]
    ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
