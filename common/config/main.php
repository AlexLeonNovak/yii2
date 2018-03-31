<?php
return [
    'name' => 'PERSPEKTIVA IMPEREAL',
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'settings' => [
            'class' => 'pheme\settings\Module',
            'sourceLanguage' => 'ru-RU'
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager'  => [
            'class'        => 'yii\rbac\DbManager',
        ],
        'settings' => [
            'class' => 'pheme\settings\components\Settings',
        ],
    ]
];
