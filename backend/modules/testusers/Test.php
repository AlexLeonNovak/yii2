<?php

namespace backend\modules\testusers;

/**
 * testusers module definition class
 */
class Test extends \yii\base\Module
{
    /**
     * @var string $layout Файл темы
     */
    public $layout = 'testlayout.php'; 
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\testusers\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        // custom initialization code goes here
    }
//    public function behaviors()
//    {
//        return [
//            'access' => [
//            'class' => AccessControl::className(),
//            'rules' => [
//                
//                ]
//            ]
//        ];
//    }
}
