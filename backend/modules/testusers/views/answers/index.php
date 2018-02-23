<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\testusers\models\AnswersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Answers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Answers', [
                'create', 
                'id_question' => $this->context->actionParams['id_question'], 
            ],
            ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_question',
            'answer',
            'correct',

            [
                'class' => 'yii\grid\ActionColumn',
//                'buttons' => [
//                    'view' => function($url, $model){
//                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
//                                Url::to(['answers/index', 'id_question' => $model->id]),
//                                ['title' => 'Просмотр ответов']
//                                );
//                    }
//                ],
            ],
        ],
    ]); ?>
</div>
