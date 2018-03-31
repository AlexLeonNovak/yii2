<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Collapse;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\testusers\models\AnswersSearch;
use backend\modules\testusers\models\Themes;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\testusers\models\QuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вопросы теста "' . $test_name . '"';
$this->params['breadcrumbs'][] = ['label' => 'Список тем тестов', 'url' => ['/testusers']];
$this->params['breadcrumbs'][] = [
        'label' => Themes::findOne(['id' => Yii::$app->request->get('id_theme')])->name,
        'url' => ['/testusers/test/index', 'id_theme' => Yii::$app->request->get('id_theme')]
    ];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="questions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать вопрос', Url::to(ArrayHelper::merge(['create'] ,Yii::$app->request->queryParams)),
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
                                'content' => collapseContent($model),                                    
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
            ],

            ['class' => 'yii\grid\ActionColumn',
            'header'=> 'Действия',
            'template' => '{view} {update} {delete} {ans}',
            'urlCreator' => function($action, $model, $key){
                return Url::to([$action, 'id' => $model->id,
                        'id_theme' => Yii::$app->request->get('id_theme'),
                        'id_test'  => Yii::$app->request->get('id_test'),
                        ]);
            },
            'buttons' => [
                'ans' => function($url, $model){
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span> Редактор ответов',
                            Url::to(['answers/create',
                                        'id_question' => $model->id,
                                        'id_theme' => Yii::$app->request->get('id_theme'),
                                        'id_test'  => Yii::$app->request->get('id_test'),
                                    ]),
                            ['title' => 'Добавить ответ']
                            );
                },
                ],                
            ],
        ],
    ]); ?>
</div>

<?php 

function collapseContent($m){
    $answers = AnswersSearch::findAll(['id_question'=> $m->id]);
    $result = [];
    foreach ($answers as $key => $a){
        $result[$key] = '<span';
        if ($a['correct']){
            $result[$key] .= ' class="success"';
        }
        $result[$key] .= '>' . $a['answer'] . '</span>';
    }
    return $result;                     
 }
$script = <<< JS
        $('span[class="success"').closest('li').addClass('list-group-item-success');
JS;
$this->registerJs($script);
?>
