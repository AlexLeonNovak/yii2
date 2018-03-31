

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
            'label' => 'Cотрудники',
            'url'   => ['/users/user/index'],
        ],
        [
            'label' => 'Зарегистрировать нового сотрудника',
            'url'   => ['/users/user/signup'],
        ],
        [
            'label' => 'Должности сотрудников',
            'url'   => ['/users/users-group/index'],
        ],
        [
            'label' => 'RBAC',
            'url'   => ['/users/default/index'],
        ]
    ]
]); ?>
<?= $content ?>

<?php $this->endContent(); ?>