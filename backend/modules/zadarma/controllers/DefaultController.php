<?php

namespace backend\modules\zadarma\controllers;

use yii\web\Controller;
use backend\modules\zadarma\components\Zadarma;
use yii\data\ArrayDataProvider;

/**
 * Default controller for the `zadarma` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $params = [
            'number' => '+380936066093',
            'message' => 'Test',
        ];
        $zadarma    = new Zadarma("bde6a59e642ed33e2c76", "4b0f8da464d6c07c3234", true);
//        $answer     = $zadarma->call('/v1/sms/send/', $params, 'post');
        $balance    = $zadarma->call('/v1/info/balance/');
        $balanceModel = new ArrayDataProvider([
            'allModels' => json_decode($balance),
        ]);
        //$answerObject = json_decode($answer);
        print_r($balance);
        return $this->render('index',[
            //'answerObject'  => $answerObject,
            'balance'       => $balance,
            'balanceModel'  => $balanceModel,
        ]);
    }
}
