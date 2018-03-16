<?php

use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\users\models\TimestampSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\modules\testusers\models\Timestamp */
/* @var $dataProviderAnswers yii\data\ActiveDataProvider */
/* @var $user_answers backend\modules\testusers\models\UserAnswer */
/* @var $questions array */

$this->title = 'Детальная статистика';
?>

<?=$this->render('../testmenu.php'); ?>

<div class="statistic-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>-->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'user.username',
                'contentOptions' => [
                    'class' => 'col-sm-9',
                ],
                'captionOptions' => [
                    'class' => 'col-sm-3',
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
                    $progress = round($model->answersCorrectCount/count($model->userAnswers)*100);
                    $html = '<div class="progress" style="margin-bottom:0">';
                    $html .= '<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:';
                    $html .= $progress . '%;">' . $progress . '%</div></div>';
                    return $html;
                }
            ]
            
        ],
    ]) ?>
    <?php foreach ($user_answers as $user_answer){ ?>
    <div class="panel panel-default">
            <div class="panel-heading"><?=$user_answer->question->question; ?></div>
            <?php if ($user_answer->answer->id == null){ ?>
                <div class="text-danger bg-danger" style="padding:10px;">
                    <strong>
                        <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                    </strong>
                        Сотрудник не ответил на этот вопрос
                </div>
            <?php } ?>
                <?= GridView::widget([
                        'layout' => "{items}",
                        'dataProvider'  => $dataProviderAnswers[$user_answer->id],
                        'rowOptions'=>function($model) use ($user_answer){
                            if ($model->answer == $user_answer->answer->answer){
                                if($user_answer->answer->correct){
                                    return ['class' => 'success'];
                                } else {
                                    return ['class' => 'danger'];
                                }
                            }
                        },
                        'columns' => [
                            
                            [
                                'format' => 'raw',
                                'value' => function ($model) use ($user_answer){
                                    if ($model->answer == $user_answer->answer->answer){
                                        if ($model->correct){
                                            return '<span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>';
                                        } else {
                                            return '<span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span>';
                                        }
                                    }   
                                    return '';
                                },
                                'label' => 'Ответ СОТР',
                                'contentOptions' => [
                                    'class' => 'text-center col-md-2',
                                ]
                            ],
                            [
                                'value' => 'answer',
                                'contentOptions' => function($model){
                                    if ($model->correct){
                                        return ['class' => 'success'];
                                    } else { // в PHP 7.2 ошибка, count(null) не проходит
                                        return ['class' => 'default'];
                                    }
                                },
                                'label' => 'Все ответы',
                            ],
                        ]
                    ]);
                ?>
            
    </div>
    <?php } ?>
</div>