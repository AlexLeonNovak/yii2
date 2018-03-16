<?php

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav nav-pills',
    ],
    'items' => [
        [
            'label' => 'Список тем тестов',
            'url'   => ['/testusers'],
        ],
        [
            'label' => 'Статистика',
            'url'   => ['/testusers/options/statistic'],
        ],
        [
            'label' => 'Настройки',
            'url'   => ['/testusers/options/settings'],
        ]
    ]
]); ?>