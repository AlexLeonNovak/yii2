<?php

use yii\grid\GridView;
//var_dump($provider);
$this->title = "Результаты прохождения теста";

?>

<h1><?=$this->title; ?></h1>

<?= GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            'question' =>[
                'attribute' => 'question',
                'label' => 'Вопрос',
            ],
            'answer' => [
                'attribute' => 'answer',
                'label' => 'Ответ',
                'contentOptions' => function($model) {
                    if ($model['is_correct']){
                        return ['class' => 'list-group-item-success'];
                    } else {
                        return ['class' => 'list-group-item-danger'];
                    }
                }
            ]
        ]
    ]); ?>
