<?php

use yii\bootstrap\Html;
use backend\modules\testusers\models\Themes;
use backend\modules\testusers\models\Test;

/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Questions */

$this->title = 'Редактирование вопроса';
$this->params['breadcrumbs'][] = ['label' => 'Список тем тестов', 'url' => ['/testusers']];
$this->params['breadcrumbs'][] = [
        'label' => Themes::findOne(['id' => Yii::$app->request->get('id_theme')])->name,
        'url' => ['/testusers/test/index', 'id_theme' => Yii::$app->request->get('id_theme')]
    ];
$this->params['breadcrumbs'][] = [
        'label' => Test::findOne(['id' => Yii::$app->request->get('id_test')])->name,
        'url' => ['/testusers/questions/index', 
            'id_theme' => Yii::$app->request->get('id_theme'),
            'id_test' => Yii::$app->request->get('id_test')]
    ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
