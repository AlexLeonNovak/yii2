<?php

namespace backend\modules\zadarma;

/**
 * zadarma module definition class
 */
class Zadarma extends \yii\base\Module
{
     /**
     * @var string $layout Файл темы
     */
    public $layout = 'zadarmalayout.php'; 

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\zadarma\controllers';
    public $components = 'backend\modules\zadarma\components';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
