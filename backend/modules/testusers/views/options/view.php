<?php

use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\users\models\TimestampSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\modules\testusers\models\Timestamp */
/* @var $dataProviderAnswers yii\data\ActiveDataProvider */
/* @var $user_answers backend\modules\testusers\models\UserAnswer */
/* @var $questions array */

$this->title = 'Детальная статистика';
$this->params['breadcrumbs'][] = ['label' => 'Список тем тестов', 'url' => ['/testusers']];
$this->params['breadcrumbs'][] = ['label' => 'Статистика', 'url' => ['/testusers/options/statistic']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="statistic-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот результат?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'user.fullName',
                'contentOptions' => [
                    'class' => 'col-sm-8',
                ],
                'captionOptions' => [
                    'class' => 'col-sm-4 align-right',
                ],
                'label' => 'Сотрудник',
            ],
            [
                'attribute' => 'timestamp',
                'format' => ['Datetime', 'php:d.m.Y H:i:s'],
            ],
            [
                'value' => $model->themeOrTest->name,
                'label' => $model->for ? 'Тема' : 'Тест',
            ],
            [
                'attribute' => 'totaltime',
                'value' => $model->totaltime ? date('i:s',$model->totaltime) . ' (м:с)' : '0 с.',
                'contentOptions' => [
                    'title' => 'Минуты : Секунды',
                ],
            ],
            [
                'value' => $model->totaltime ? round($model->totaltime / count($model->userAnswers), 2) . ' с.' : '0 с.',
                'label' => 'Среднее время затраченное на вопрос',
            ],
            [
                'attribute' => 'answersCorrectCount',
                'label' => 'Правильных ответов',
                'contentOptions' => [
                    'class' => 'text-success',
                ],
            ],
            [
                'value' => count($model->userAnswers) - $model->answersCorrectCount,
                'label' => 'Неправильных ответов',
                'contentOptions' => [
                    'class' => 'text-danger',
                ],
            ],
            [
                'value' => count($model->userAnswers),
                'label' => 'Всего вопросов',
            ],
            [
                'label' => 'Успешность',
                'format' => 'raw',
                'value' => function ($model) {
                    $progress = round($model->answersCorrectCount / count($model->userAnswers) * 100);
                    $html = '<div class="progress" style="margin-bottom:0;background-color:#aaa;">';
                    $html .= '<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:';
                    $html .= $progress . '%;">' . $progress . '%</div></div>';
                    return $html;
                }
            ]
        ],
    ])
    ?>
    <?= 
        GridView::widget([
            'layout' => "{pager}{items}{pager}",
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'question.question',
                    'group' => true,
                ],
                
                [
                    'attribute' => 'answers.answer',
                    'format' => 'raw',
                    'value' => function ($model){
                        $result = [];
                        foreach ($model->answers as $key => $ans){
                            $result[$key] = '<div';
                            if ($ans->correct){
                                $result[$key] .= ' class="list-group-item-success"';
                            }
                            $result[$key] .= '>' . $ans->answer . '</div>';
                        }
                        return implode('<br>', $result);
                    },
//                    'contentOptions' => [
//                        'class' => 'list-group',
//                    ],
                    'group' => true,
                ],
                [
                    'attribute' => 'answer.answer',
                    'format' => 'raw',
                    'contentOptions' => function($model) {
                            if (isset($model->answer->correct)) {
                                if ($model->answer->correct){
                                    return ['class' => 'success'];
                                }     
                            }
                            return ['class' => 'danger'];
                        },
                    'value' => function ($model){
                            if (isset($model->answer->correct)) {
                                if ($model->answer->correct){
                                    return '<span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span> ' . $model->answer->answer;
                                } else {
                                    return '<span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span> ' . $model->answer->answer;
                                }
                            } else {
                                return '<i>(Нет ответа)</i>';
                            }
                        },
                    'label' => 'Ответ СОТР',
//                        $html = '<ul class="list-group">';
//                        var_dump($model->answer->answer);
//                        foreach ($model->answer as $ans){
//                            $html .= '<li class="list-group-item';
////                            if ($ans->correct){
////                                $html .= ' list-group-item-success';
////                            }
//                            $html .= '">' . $ans[3] . '</li>';
//                        }
//                        return $html . '</ul>';
//                    }
                    //'group' => true,
                ],
            ],
        ]);
        
    ?>
        
</div>