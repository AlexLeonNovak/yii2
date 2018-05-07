<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Collapse;
use yii\bootstrap\Modal;
use frontend\modules\testusers\TestAsset;

/* @var $this yii\web\View */

TestAsset::register($this);
$onClick = 'fullscreen(document.documentElement);';

$this->title = "Модуль тестирования сотрудников";
$this->params['breadcrumbs'][] = $this->title;

foreach ($tests as $test){
    $content[$test->id_theme][] = Html::a($test->name, '#test-modal',
                [
                    'class' => 'col-md-4',
                    'data-toggle' =>'modal',
                    'id_test' => $test->id,
                    'data-name' => $test->name,
                ]) .
            Html::a('Посмотреть результаты',
                Url::to(['result', 'id_test' => $test->id]),[
                    'class' => 'btn btn-default btn-xs',
            ]). '   '
            . Html::a('Пройти тест', '#test-modal',
                [
                    'class' => 'btn btn-default btn-xs',
                    'data-toggle' =>'modal',
                    'id_test' => $test->id,
                    'data-name' => $test->name,
                ]);
}

foreach ($themes as $key => $theme){
    if (isset($content[$theme->id])){
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
                    . Html::a('Пройти всю тему','#test-modal',
                        [
                            'class' => 'btn btn-default btn-xs',
                            'data-toggle' =>'modal',
                            'id_theme' => $theme->id,
                            'data-name' => $theme['name'],
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
        <?= Yii::$app->user->identity->fullName; ?>, добро пожаловать в модуль
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
<?php Modal::begin([
    'id' => 'test-modal',
]); ?>
    <div class="test-message">
        <span class="text-danger">ВНИМАНИЕ!!! </span>
        <p>
            <?= Yii::$app->settings->get('TestMsg.msgWarning'); ?>
        </p>
        
    </div>
    <div class="modal-footer">
        <?= Html::a('Понимаю. Начать тестирование', ['test'], ['class' => 'btn btn-success']); ?>
    </div>
<?php Modal::end(); ?>
</div>
<?php $this->registerJs('var timer = 0;',  $this::POS_HEAD);