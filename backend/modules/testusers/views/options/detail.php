<?php

use kartik\grid\GridView;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\testusers\models\Timestamp */

$this->title = 'Сводная статистика';
$this->params['breadcrumbs'][] = ['label' => 'Список тем тестов', 'url' => ['/testusers']];
$this->params['breadcrumbs'][] = ['label' => 'Статистика', 'url' => ['/testusers/options/statistic']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistic-detail">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php ActiveForm::begin([
            'layout'=>'horizontal',
        ]); ?>
    <div class="form-group">
        <?= Html::label('Выбор сотрудника', null, [
            'class' => 'col-sm-2 control-label',
        ]); ?>
        <div class="col-sm-8">
    <?= Html::dropDownList('id_user', (isset($selected) ? $selected : null), $user_list, [
        'class' => 'form-control',
        'prompt' => 'Выберете сотрудника',
        'onchange' => 'this.form.submit();',
    ]); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    
    <?php if (!isset($dataProvider)){ ?>
    <div class="well well-lg">Нет данных</div>
    <?php } else { ?>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        
        [
            'attribute' => 'themeOrTest.name',
            'value' => function ($model) {
                return $model->for ? 'Тема: ' . $model->themeOrTest->name : 'Тест: ' . $model->themeOrTest->name;
            },
            'label' => 'Тема/Тест',
            'group' => true,
            'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns'=>[[0,2]], // columns to merge in summary
                    'content'=>[             // content to show in each summary cell
                        0=>'Всего (' . ($model->for ? 'Тема: ' . $model->themeOrTest->name : 'Тест: ' . $model->themeOrTest->name) . ')',
                        3=>GridView::F_SUM,
                        4=>GridView::F_SUM,
                        5=>GridView::F_AVG,
                    ],
                    'contentFormats'=>[      // content reformatting for each summary cell
                        3=>['format'=>'number', 'decimals'=>0],
                        4=>['format'=>'number', 'decimals'=>0],
                        5=>['format'=>'number', 'decimals'=>2],
                    ],
                    'contentOptions'=>[      // content html attributes for each summary cell
                        0=>['style'=>'font-variant:small-caps'],
                        3=>['style'=>'text-align:right'],
                        4=>['style'=>'text-align:right'],
                        5=>['style'=>'text-align:right'],
                    ],
                    // html attributes for group summary row
                    'options'=>['class'=>'info','style'=>'font-weight:bold;']
                ];
            }
        ],
        [
            'attribute' => 'timestamp',
            'format' => ['Datetime', 'php:d.m.Y H:i:s'],
        ],
        [
            'attribute' => 'userAnswersCount',
            'label' => 'Количество вопросов'
        ],
        [
            'attribute' => 'answersCorrectCount',
            'label' => 'Количество правильных ответов'
        ],
        [
            'value' => function ($model){
                return $model->userAnswersCount ? round($model->answersCorrectCount/$model->userAnswersCount*100) . '%' : 0 . '%';
            },
            'label' => '% правильных ответов'    
        ],
    ]
]);
    } //endif
?>

</div>
