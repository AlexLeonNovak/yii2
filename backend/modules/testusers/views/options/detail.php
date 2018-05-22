<?php

use kartik\grid\GridView;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\testusers\models\UserAnswer */

$this->title = 'Сводная статистика';
$this->params['breadcrumbs'][] = ['label' => 'Список тем тестов', 'url' => ['/testusers']];
$this->params['breadcrumbs'][] = ['label' => 'Статистика', 'url' => ['/testusers/options/statistic']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="statistic-detail">

    <h1><?= Html::encode($this->title) ?></h1>
    <pre>
        <?php 
        var_dump($model);
        ?>
    </pre>
    
</div>