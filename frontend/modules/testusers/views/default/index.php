<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Collapse;

$this->title = "Модуль тестирования сотрудников";
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->session['breadcrumbs-themes'] = [
            'label' => $this->title,
            'url'   => Yii::$app->request->url,
    ];

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
                Url::to(['test', 'id_test' => $test->id]),[
                    'class' => 'col-md-4',
                ]) .
                Html::a('Посмотреть результаты',
                Url::to(['result', 'id_test' => $test->id]),[
                    'class' => 'btn btn-default btn-xs',
                ]); 
    }
    foreach ($themes as $theme){
        $items[] = 
            [
                'encode' => false,
                'label' => '<span class="col-md-4">' . $theme['name']
                    . ' <small>(посмотреть все тесты)</small></span>'
                    . Html::a('Посмотреть результаты',
                        Url::to(['result', 'id_theme' => $theme->id]),[
                            'class' => 'btn btn-default btn-xs',
                        ]) 
                    . '   '
                    . Html::a('Пройти всю тему',
                        Url::to(['test', 'id_theme' => $theme->id]),[
                            'class' => 'btn btn-default btn-xs',
                        ]),

//                'labelOptions' => [
//                    'options' => [
//                        'class' => 'col-md-4',
//                    ],
//                ],
                'content' => $content[$theme->id],
            ];
    }
    ?>
    <?= Collapse::widget([
        'items' => $items,        
    ]);
    ?>

</div>
