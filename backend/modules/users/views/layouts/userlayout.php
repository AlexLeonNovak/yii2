

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
            'items' => [
                [
                    'label' => 'Список сотрудников',
                    'url'   => ['/users/user/index'],
                ],
                [
                    'label' => 'Регистация нового сотрудника',
                    'url'   => ['/users/user/signup'],
                ],
                [
                    'label' => 'Список контактов',
                    'url'   => ['/users/users-contact/index'],
                ],
            ],
        ],
        [
            'label' => 'Должности сотрудников',
            'items' => [
                [
                    'label' => 'Список должностей',
                    'url'   => ['/users/users-group/index'],
                ],
                [
                    'label' => 'Добавление новой должности',
                    'url'   => ['/users/users-group/create'],
                ],
            ],   
        ],
        [
            'label' => 'Контроль доступа <span class="label label-danger">RBAC</span>',
            'url'   => ['/users/default/index'],
            'items' => [
                [
                    'label' => 'Справочник действий',
                    'url'   => ['/users/default/index']
                ],
                [
                    'label' => 'Добавление нового действия',
                    'url'   => ['/users/default/create']
                ]
            ],
        ],
        
    ]
]); ?>
<?= $content ?>

<?php $this->endContent(); ?>