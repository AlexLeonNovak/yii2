<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Questions */

$this->title = 'Создать вопрос для теста "'.$model->test_name.'"';
$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//var_dump($model);die;
?>
<div class="questions-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model'   => $model,
    ]) ?>

</div>
