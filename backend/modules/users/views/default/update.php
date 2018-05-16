<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelActions backend\modules\users\models\AuthActions */
/* @var $modelControllers backend\modules\users\models\AuthControllers */
/* @var $modelModules backend\modules\users\models\AuthModules */

$this->title = 'Редактирование действия';
$this->params['breadcrumbs'][] = ['label' => 'Контроль доступа', 'url' => ['/users/default']];
$this->params['breadcrumbs'][] = ['label' => 'Справочник действий', 'url' => ['/users/default/directory']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-default-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelActions'      => $modelActions,
        'modelControllers'  => $modelControllers,
        'modelModules'      => $modelModules,
        'isUpdate'            => true,
    ]) ?>

</div>
