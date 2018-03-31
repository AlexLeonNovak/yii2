

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<?php

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav nav-tabs', 
    ],
    'encodeLabels' => false,
    'items' => [
        [
            'label' => '<span class="glyphicon glyphicon-list" aria-hidden="true"></span> Список тем тестов',
            'url'   => ['/testusers/themes/index'],
        ],
        [
            'label' => '<span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Статистика',
            'url'   => ['/testusers/options/statistic'],
        ],
        [
            'label' => '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Настройки таймера',
            'url'   => ['/testusers/test-settings/index'],
        ],
        [
            'label' => '<span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Настройки сообщений',
            'url'   => ['/testusers/test-settings/msg-update'],
        ]
    ]
]); ?>
<?= $content ?>

<?php $this->endContent(); ?>