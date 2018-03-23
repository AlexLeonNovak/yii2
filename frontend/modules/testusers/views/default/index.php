<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Collapse;

$this->title = "Модуль тестирования сотрудников";
$this->params['breadcrumbs'][] = $this->title;

foreach ($tests as $test){
    $content[$test->id_theme][] = Html::a($test->name,
                Url::to(['test', 'id_test' => $test->id]),[
                    'class' => 'col-md-4',
            ]) .
            Html::a('Посмотреть результаты',
                Url::to(['result', 'id_test' => $test->id]),[
                    'class' => 'btn btn-default btn-xs',
            ]). '   '
            . Html::a('Пройти тест',
                Url::to(['test', 'id_test' => $test->id]),[
                    'class' => 'btn btn-default btn-xs',
                ]);
}

foreach ($themes as $key => $theme){
    if ($content[$theme->id]){
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
                'content' => $content[$theme->id]
            ];
    } else {
        $items[] = 
            [
                'label' => $theme['name'],
                'content' => '<i>(Здесь пока нет тестов)</i>',
            ];
    }
}

?>
<div class="testusers-default-index">
    <h1><?= $this->title ?></h1>
    <p class="lead">
        <?= Yii::$app->user->identity->username; ?>, добро пожаловать в модуль
        тестирования сотрудников.</p>
<?php if ($items) { ?>
    <p>
        Для начала выберете тест
    </p>

    <?= Collapse::widget([
        'items' => $items,        
    ]);
    ?>
<?php } else { ?>
    <div class="alert alert-danger">Для вашей должности пока еще не созданы тесты</div>
<?php } ?>

</div>
