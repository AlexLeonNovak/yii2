<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Collapse;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\testusers\models\AnswersSearch;

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
                    'id_test' => Yii::$app->getRequest()->get('id_test'),
                ],
                ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'question' => [
                'attribute' => 'question',
                'format'    => 'raw',
                'value'     => function($model){
                    return Collapse::widget([
                        'items' => [
                            [
                                'label' => $model->question,
                                'content' => ArrayHelper::map(
                                        AnswersSearch::findAll(['id_question'=> $model->id]),
                                            'id', 'answer'),
                                'options' => [
                                    'class' => 'panel-info',
                                ]
                            ],
                        ],
                        'options' => [
                            'style' => 'margin-bottom: 0;',
                        ]
                    ]);
                },
//                'value' => function ($model){
//                    $html = '<div class="panel panel-info">';
//                    $html .= '<div class="panel-heading">' . $model->question . '</div>';
//                    $answers = AnswersSearch::findAll(['id_question'=> $model->id]);
//                    $html .= '<ul class="list-group">';
//                    foreach ($answers as $a){
//                        $html .= '<li class="list-group-item';
//                        if ($a['correct']){
//                            $html .= ' list-group-item-success';
//                        }
//                        $html .= '">' . $a['answer'] . '</li>';
//                    }
//                    $html .= '</ul></div>';
//                    return $html;
//                }
                ],

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
