<?php

//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\DetailView;

/* @var $model backend\modules\testusers\models\Timestamp */
/* @var $dates[] backend\modules\testusers\models\Timestamp */
/* @var $dataProvider backend\modules\testusers\models\UserAnswer */
/* @var $this yii\web\View */

//var_dump($provider);
$this->title = 'Результаты прохождения ' . ($model->for ? 'темы' : 'теста') . ' "'
        . $model->themeOrTest->name . '"';
$this->params['breadcrumbs'][] = ['label' => 'Модуль тестирования сотрудников', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testusers-default-result">
    <h1><?= $this->title; ?></h1>
    <?php foreach ($dates as $i => $date) { ?>
        <?php if($date->violation){ ?>
    <div class="alert alert-danger">
        <strong>НАРУШЕНИЕ!!!</strong><br>
        <?= Yii::$app->settings->get('TestMsg.msgViolation'); ?>
    </div>
    <?php } ?>
        <div class="panel panel-info">
            <div class="panel-heading">Дата и время прохождения теста: <b>
        <?= Yii::$app->formatter->asDatetime($date->timestamp, 'php:d.m.Y H:i:s');?></b></div>
            <div class="panel-body">
                <?=
                DetailView::widget([
                    'model' => $date,
                    'attributes' => [
                        [
                            'attribute' => 'totaltime',
                            'value' => $date->totaltime ? $date->totaltime . ' с.' : '0 с.',
                        ],
                        [
                            'value' => $date->totaltime ? round($date->totaltime / count($date->userAnswers), 2) . ' с.' : '0 с.',
                            'label' => 'Среднее время затраченное на вопрос',
                        ],
                        [
                            'attribute' => 'answersCorrectCount',
                            'label' => 'Правильных ответов',
                            'contentOptions' => [
                                'class' => 'text-success col-sm-8',
                            ],
                            'captionOptions' => [
                                'class' => 'col-sm-4',
                            ],
                        ],
                        [
                            'value' => count($date->userAnswers) - $date->answersCorrectCount,
                            'label' => 'Неправильных ответов',
                            'contentOptions' => [
                                'class' => 'text-danger',
                            ],
                        ],
                        [
                            'value' => count($date->userAnswers),
                            'label' => 'Всего вопросов',
                        ],
                        [
                            'label' => 'Успешность',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $progress = round($model->answersCorrectCount/count($model->userAnswers)*100);
                                $html = '<div class="progress" style="margin-bottom:0;background-color:#aaa;">';
                                $html .= '<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:';
                                $html .= $progress . '%;">' . $progress . '%</div></div>';
                                return $html;
                            }
                        ]
                    ]
                ]);
                ?>
                <?=
                GridView::widget([
                    'layout' => "{items}",
                    'dataProvider' => new ActiveDataProvider(['query' => $date->getUserAnswers()]),
                    'columns' => [
                        [
                            'attribute' => 'question.question',
                            'contentOptions' => [
                                'class' => 'col-md-4',
                            ],
                            'group' => true,
                        ],
                        [
                            'attribute' => 'correctAnswer.answer',
                            'label' => 'Правильный ответ',
                            'contentOptions' => [
                                'class' => 'col-md-4',
                            ],
                            'group' => true,
                        ],
                        [
                            'format' => 'html',
                            'attribute' => 'answer.answer',
                            'label' => 'Ваш ответ',
                            'contentOptions' => function($model) {
                                if (isset($model->answer->correct)) {
                                    if ($model->answer->correct) {
                                        return ['class' => 'list-group-item-success'];
                                    }
                                }
                                return ['class' => 'list-group-item-danger'];
                            },
                            'value' => function($model) {
                                if (!isset($model->answer->answer)){
                                    return '<i>(Нет ответа)</i>';
                                }
                                return $model->answer->answer;
                            },
                        ],
                    ]
                ]); 
                ?>
            </div>
        </div>
<?php } ?>
</div>

