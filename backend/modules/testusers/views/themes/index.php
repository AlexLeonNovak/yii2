<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\modules\users\models\UsersGroup;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\testusers\models\ThemesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список тем тестов';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="themes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать тему', ['create'],['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->name, Url::to(['test/index', 'id_theme' => $model->id]),
                                ['title' => 'Просмотр тестов']);
                },
                'contentOptions' => [
                    'class' => 'col-sm-3',
                ]
            ],
            [
                'attribute' => 'id_group',
                'format'=>'raw',
                'value' => function($model){
                    return '<span class="label label-success">' . $model->group->name 
                            . '</span> <span class="label label-def">'
                            . implode('</span> <span class="label label-def">'
                                    , ArrayHelper::getColumn($model->groups, 'name'))
                            . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel,
                        'id_group',
                        ArrayHelper::map(UsersGroup::find()->all(), 'id', 'name'),
                        ['class' => 'form-control','prompt' => 'Все']
                        ),
                'label' => 'Должности сотрудников',
                'contentOptions' => [
                    'style' => 'font-size:16px',
                ]
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Действия',
                'template' => '{view} {update} {delete} {addtest}',
                'buttons' => [
                    'view' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                Url::to(['test/index', 'id_theme' => $model->id]),
                                ['title' => 'Просмотр тестов']
                                );
                    },
                    'addtest' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>',
                                Url::to(['test/create', 'id_theme' => $model->id]),
                                ['title' => 'Добавить тест']
                                );
                    },
                ],
                'contentOptions' => [
                    'class' => 'col-sm-1',
                ]
            ],
        ],
    ]); ?>
</div>
<?php
$css = <<< CSS
.label-def{
    color: #555555;
    background: #f5f5f5;
    border: 0.1em solid #ccc;
    cursor: default;
    padding: 0.1em .6em 0.2em;
}
CSS;

$this->registerCss($css);