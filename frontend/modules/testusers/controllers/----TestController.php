<?php

namespace app\modules\testusers\controllers;

use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex(){
        //echo "TestController";
        
        return $this->render('test');
    }
}

