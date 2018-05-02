<?php

namespace backend\modules\zadarma\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\zadarma\components\ZadarmaAPI;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use backend\modules\zadarma\models\Zadarma;

/**
 * Default controller for the `zadarma` module
 */
class DefaultController extends Controller
{
    private $caller_id;
    private $called_did;
    private $call_start;
    private $pbx_call_id;
    private $internal;
    private $destination;
    
    const API_SECRET = '4b0f8da464d6c07c3234';
    const API_KEY ='bde6a59e642ed33e2c76';
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
    
    public function beforeAction($action) {
        parent::beforeAction($action);
    }

        /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $params = [
            'from' => '442037690165',
            'to' => '4444',
           // 'sip' => '976463'
        ];
        $zadarma    = new ZadarmaAPI(self::API_KEY, self::API_SECRET, true);
        //$answer     = $zadarma->call('/v1/sms/send/', $params, 'post');
        $balance    = json_decode($zadarma->call('/v1/info/balance/'));
//        $balanceModel = new ArrayDataProvider([
//            'allModels' => json_decode($balance, true),
//        ]);
        $call       = $zadarma->call('/v1/request/callback/', $params);
        //$answerObject = json_decode($answer);
        //print_r(json_decode($balance));
        return $this->render('index',[
            //'answerObject'  => $answerObject,
            'balance'       => $balance,
            //'balanceModel'  => $balanceModel,
            'call' => $call,
        ]);
    }
    /**
     * Функция осуществления звонка
     */
    public function actionCall() 
    {
        $params = [
            'from' => '442037691880',
            'to' => '4444',
        //    'sip' => 'YOURSIP'
        ];
        $zadarma    = new ZadarmaAPI("bde6a59e642ed33e2c76", "4b0f8da464d6c07c3234", true);
        $call       = $zadarma->call('/v1/request/callback/', $params);
        
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
