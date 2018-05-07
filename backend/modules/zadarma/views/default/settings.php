<?php
/**
 * @author Alex Novak <alexleonnovak@gmail.com>
 */ 

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use backend\modules\zadarma\ZadarmaAsset;

/* @var $balance backend\modules\zadarma\components\Zadarma */
/* @var $this yii\web\View */

ZadarmaAsset::register($this);
$this->title = 'Настройки API';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="zadarma-settings">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="alert alert-info">
            <p>Чтобы получить ключи авторизации перейдите в 
            <?= Html::a('личный кабинет', 'https://my.zadarma.com/api/', ['class' => 'alert-link']); ?> 
            и следуйте инструкциям указаных там <br>
            А так же для получения уведомления о звонках поставте все галочки и скопируйте в соответствующее поле эту ссылку
            </p><br>
            <div class="col-xs-10">
            <div class="input-group">
                <input type="text" readonly class="form-control col-xs-8" id="foo"
                       value="<?= Yii::$app->request->hostInfo ?>/admin/zadarma/default/0d0dfb2682192387a2e4325e97b36b32">
                <span class="input-group-btn">
                    <button class="btn btn-default copy" data-clipboard-target="#foo" data-toggle="tooltip" title="Скопировано">
                        <span class="glyphicon glyphicon-copy"></span> Скопировать в буфер обмена
                    </button>
                </span>
            </div>
            </div>
            <br><br><br>
            <div class="text-right">
            <?= Html::a('Перейти в личный кабинет', 'https://my.zadarma.com/api/', ['class' => 'btn btn-info', 'target'=>'_blank']) ?>
            </div>
        </div>

        <?php $form = ActiveForm::begin([
            'class' => 'form-horizontal',
        ]); ?>

        <?= $form->field($model, 'key')->textInput() ?>

        <?= $form->field($model, 'secret')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    

</div>
<?php
$js = <<< JS
       var clip = new ClipboardJS('.copy');
        function hideTooltip() {
            setTimeout(function() {
              $('.copy').tooltip('hide');
            }, 2000);
          }
        clip.on('success', function(e) {
            $('.copy').tooltip('show');
            hideTooltip();
        });
        $('.copy').tooltip({
            trigger: 'click',
            placement: 'bottom',
        });
JS;
$this->registerJs($js);