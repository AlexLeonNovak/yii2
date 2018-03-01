<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Collapse;

$this->title = "Модуль тестирования сотрудников";


?>
<div class="testusers-default-index">
    <h1><?= $this->title ?></h1>
    <p class="lead">
        <?= Yii::$app->user->identity->username; ?>, добро пожаловать в модуль
        тестирования сотрудников.</p>
    <p>
        Для начала выберете тест
    </p>
    
    <?php 
    foreach ($tests as $test){
        $content[$test->id_theme][] = Html::a($test->name,
                Url::to(['test', 'id_test' => $test->id])); 
    }
    foreach ($themes as $theme){
        $items[] = 
            [
                'label' => $theme['name'],
                'content' => $content[$theme->id],
            ];
    }
    ?>
    <?= Collapse::widget([
        'items' => $items,        
    ]);
    ?>

</div>
