

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
            'label' => '<span class="glyphicon glyphicon-list" aria-hidden="true"></span> Журнал звонков',
            'url'   => ['/zadarma/default/index'],
        ],
        [
            'label' => '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Настройки API',
            'url'   => ['/zadarma/default/settings'],
        ],
    ]
]); ?>
<?= $content ?>

<?php $this->endContent(); ?>