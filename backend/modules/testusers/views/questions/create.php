<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\testusers\models\Questions */

$this->title = 'Создать вопрос';
$this->params['breadcrumbs'][] = ['label' => 'Список тем тестов', 'url' => ['/testusers']];
$this->params['breadcrumbs'][] = [
        'label' => $model->theme->name,
        'url' => ['/testusers/test/index', 'id_theme' => Yii::$app->request->get('id_theme')]
    ];
$this->params['breadcrumbs'][] = [
        'label' => $model->test->name,
        'url' => ['/testusers/questions/index', 
            'id_theme' => Yii::$app->request->get('id_theme'),
            'id_test' => Yii::$app->request->get('id_test')]
    ];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="questions-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model'   => $model,
    ]) ?>

</div>
