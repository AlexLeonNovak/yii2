<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use unclead\multipleinput\TabularInput;
use unclead\multipleinput\TabularColumn;

/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Answers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answers-form">

    <?php $form = ActiveForm::begin([
    'id'                        => 'tabular-form',
    'enableAjaxValidation'      => true,
    'enableClientValidation'    => true,
    'validateOnChange'          => true,
    'validateOnSubmit'          => true,
    'validateOnBlur'            => false,
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]) ?>

<?= TabularInput::widget([
    'models' => $models,
    'attributeOptions' => [
        'enableAjaxValidation'      => true,
        'enableClientValidation'    => true,
        'validateOnChange'          => true,
        'validateOnSubmit'          => true,
        'validateOnBlur'            => false,
    ],
    'columns' => [
        [
            'name' => 'id',
            'type' => TabularColumn::TYPE_HIDDEN_INPUT,
        ],
        [
            'name'  => 'correct',
            'title' => '.',
            'type'  => TabularColumn::TYPE_RADIO,
            'options' => [
                'labelOptions' => [
                    'class' => 'btn btn-default',
                ],
                'label' => '<i class="fa fa-check glyphicon glyphicon-ok"></i>',
                'class' => 'hidden',
            ],
            'headerOptions' => [
                'style' => 'width: 20px;',
            ]
        ],
        [
            'name'  => 'answer',
        ],
    ],
]); ?>


<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']);?>
<?php ActiveForm::end();?>
    
</div>

<?php 
$script = <<< JS
        $('input[type=radio]:checked').closest('label').removeClass('btn-default').addClass('btn-success').attr('style', 'opacity:1');
        $(document).on('click', 'input[type=radio]', function(){
           // $('input[type=radio]:checked').closest('label').removeClass('btn-default').addClass('btn-success');
            $('input[type=radio]').change(function() {
                $('input[type=radio]:checked').not(this).prop('checked', false);
                $('input[type=radio]:checked').closest('label').removeClass('btn-default').addClass('btn-success').attr('style', 'opacity:1');
                $('input[type=radio]').not(this).closest('label').removeClass('btn-success').addClass('btn-default').removeAttr('style');
            });
        });
JS;
$this->registerJs($script);
$css = <<< CSS
        .multiple-input-list__item .radio{
            margin: 0;
        }
        label.btn{
            padding-left: 12px;
            opacity: 0.7;
        }
        label.btn:hover{
            opacity: 1;
        }
CSS;
$this->registerCss($css);
?>

