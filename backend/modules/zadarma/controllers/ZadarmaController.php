<?php

namespace backend\modules\zadarma\controllers;

use Yii;
use yii\console\Controller;
use backend\modules\zadarma\components\ZadarmaAPI;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use backend\modules\zadarma\models\Zadarma;

class ZadarmaController extends Controller
{
    private $caller_id;
    private $called_did;
    private $call_start;
    private $pbx_call_id;
    private $internal;
    private $destination;
    
    const API_SECRET    = '4b0f8da464d6c07c3234';
    const API_KEY       = 'bde6a59e642ed33e2c76';
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['0d0dfb2682192387a2e4325e97b36b32'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'signup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function action0d0dfb2682192387a2e4325e97b36b32() 
    {
        //проверочный код для подтверждения скрипта задармой
        if (isset($_GET['zd_echo'])) {exit($_GET['zd_echo']);}
        $request = Yii::$app->getRequest();
        if ($request->isPost) {
            // получаем переменные
            // номер звонящего
            $this->caller_id = Yii::$app->request->post('caller_id'); 
            // номер, на который позвонили
            $this->called_did = Yii::$app->request->post('called_did');
            // время начала звонка
            $this->call_start = Yii::$app->request->post('call_start') or die;
            // id звонка;
            $this->pbx_call_id = Yii::$app->request->post('pbx_call_id');
            // (опциональный) внутренний номер
            $this->internal = Yii::$app->request->post('internal');
            // (опциональный) набранный номер при исходящих звонках
            $this->destination = Yii::$app->request->post('destination');

            $signature = Yii::$app->request->headers->get('Signature');  // Signature is send only if you have your API key and secret
            $signatureTest = base64_encode(hash_hmac('sha1', $this->caller_id . $this->called_did . $this->call_start, self::API_SECRET));
            if ($signature == $signatureTest) {
                $model = new Zadarma();
                $model->caller_id = $this->caller_id;
                $model->called_did = $this->called_did;
                $model->call_start = $this->call_start;
                $model->pbx_call_id = $this->pbx_call_id;
                $model->internal = $this->internal;
                $model->destination = $this->destination;
                $model->save();
            }
        }
    }
}