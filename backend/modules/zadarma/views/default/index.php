<?php
/**
 * @author Alex Novak <alexleonnovak@gmail.com>
 * 
 * @var $balance backend\modules\zadarma\components\Zadarma
 */
use yii\widgets\DetailView;

?>


<div class="zadarma-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p><?php print_r($balance); ?>
        
    </p>
    <?=    DetailView::widget([
        'model' => $balanceModel,
    ]);?>
</div>
