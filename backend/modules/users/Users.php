<?php

namespace backend\modules\users;

/**
 * users module definition class
 */
class Users extends \yii\base\Module
{
    public $layout = 'userlayout.php';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\users\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
