<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\testusers\models\QuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//var_dump($this->context->actionParams['id_test']);die;
$this->title = 'Вопросы теста "' . $test_name . '"';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать вопрос', [
                    'create',
                    'id_test' => $this->context->actionParams['id_test']
                ],
                ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'id_test',
            'question',

            ['class' => 'yii\grid\ActionColumn',
            'header'=> 'Действия',
            'template' => '{view} {update} {delete} {addanswer}',
            'buttons' => [
                'view' => function($url, $model){
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            Url::to(['answers/index', 'id_question' => $model->id]),
                            ['title' => 'Просмотр ответов']
                            );
                },
                'addanswer' => function($url, $model){
                    return Html::a('<span class="glyphicon glyphicon-plus"></span>',
                            Url::to(['answers/create', 'id_question' => $model->id]),
                            ['title' => 'Добавить ответ']
                            );
                },
                ],                
            ],
        ],
    ]); ?>
</div>
