<?php

use yii\bootstrap\Html;
use backend\modules\users\UsersAsset;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $modelActions backend\modules\users\models\AuthActions */
/* @var $modelControllers backend\modules\users\models\AuthControllers */
/* @var $modelModules backend\modules\users\models\AuthModules */
/* @var $model backend\modules\users\models\AuthActions */
/* @var $searchModel backend\modules\users\models\AuthActionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

UsersAsset::register($this);

$this->title = 'Справочник действий';
$this->params['breadcrumbs'][] = ['label' => 'Контроль доступа', 'url' => ['/users/default']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-default-directory">
    <h1><?= Html::encode($this->title); ?></h1>

    <?= Html::a('Добавить запись', 'create', ['class' => 'btn btn-success']); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'module_name',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->module->name . '<br><small class = "text-muted"><b>Описание:</b> '
                            . $model->module->description . '</small>';
                },
                'label' => 'Модуль',        
                'group' => true,
                'contentOptions' => function ($model) {
                    return [
                            'data-module' => $model->module->id,
                            'class' => 'add-user',
                        ];
                },
            ],
            [
                'attribute' => 'controller_name',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->controller->name . '<br><small class = "text-muted"><b>Описание:</b> '
                            . $model->controller->description . '</small>';
                },
                'label' => 'Контроллер',
                'group' => true,
                'contentOptions' => function ($model) {
                    return [
                            'data-controller' => $model->controller->id,
                            'class' => 'add-user',
                        ];
                },
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->name . '<br><small class = "text-muted"><b>Описание:</b> '
                            . $model->description . '</small>';
                },
                'contentOptions' => function ($model) {
                    return [
                            'data-action' => $model->id,
                            'class' => 'add-user',
                        ];
                },
            ],
            [
                'attribute' => 'id_user',
                'label' => 'Сотрудники',
                'format' => 'raw',
                'value' => function ($model) {
                    return implode('<br>', ArrayHelper::map(
                                    User::find()->where([
                                        'id' => Yii::$app->authManager->getUserByActionId($model->id)
                                    ])->orderBy('lastname')->all(), 
                            'id', 'fullNameInitials'));
                },
                'contentOptions' => function ($model) {
                    return [
                            'data-action' => $model->id,
                            'class' => 'add-user',
                        ];
                },
                'filter' => Html::activeDropDownList($searchModel, 'id_user',
                        ArrayHelper::map(User::find()->all(), 'id', 'fullNameInitials', 'usersGroup.name'),
                        ['class' => 'form-control', 'prompt' => 'Все']),
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ]
    ]);
    ?>
    <?php
    Modal::begin([
        'id' => 'modalAddUserAccess',
    ]);
    Modal::end();
    ?>
</div>

<?php
$css = <<< CSS
        .add-user:hover {
            color: #3c763d;
            background-color: #dff0d8!important;
            cursor: pointer;
        }
CSS;

$this->registerCss($css);

$js = <<< JS
        $('.add-user').click(function(){
            var data = $(this).data();
            if (data.action) {
                var str_load = 'modal?action=' + data.action;
            }
            if (data.controller) {
                var str_load = 'modal?controller=' + data.controller;
            }
            if (data.module) {
                var str_load = 'modal?module=' + data.module;
            }
            $('#modalAddUserAccess').load(str_load);
            $('#modalAddUserAccess').modal('show');
        });
JS;

$this->registerJs($js);