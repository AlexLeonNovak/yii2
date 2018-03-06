<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\testusers\models\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Тесты на тему "'. $theme_name . '"';
$this->params['breadcrumbs'][] = Yii::$app->session['breadcrumbs-themes'];
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->session['breadcrumbs-test'] = [
        'label' => $this->title,
        'url'   => Yii::$app->request->url,
];
?>
<div class="test-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать тест', 
                ['create', 'id_theme' => Yii::$app->getRequest()->get('id_theme')], 
                ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name' => [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->name, Url::to(['questions/index', 'id_test' => $model->id]),
                                ['title' => 'Просмотр вопросов']);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Действия',
                'template' => '{view} {update} {delete} {addquestion}',
                'buttons' => [
                    'view' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                Url::to(['questions/index', 'id_test' => $model->id]),
                                ['title' => 'Просмотр вопросов']
                                );
                    },
                    'addquestion' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>',
                                Url::to(['questions/create', 'id_test' => $model->id]),
                                ['title' => 'Добавить вопрос']
                                );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
