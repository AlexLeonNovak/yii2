<?php

namespace backend\modules\zadarma\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\zadarma\components\ZadarmaAPI;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\modules\zadarma\models\Zadarma;
use backend\modules\zadarma\models\ZadarmaSearch;

/**
 * Default controller for the `zadarma` module
 */
class DefaultController extends Controller
{
    
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
                        'actions' => ['settings', 'index', 'get-record'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-record' => ['POST'],
                ],
            ],
        ];
    }
    
    function actions(){
        return [
            'settings' => [
                'class' => 'pheme\settings\SettingsAction',
                'modelClass' => 'backend\modules\zadarma\models\ZadarmaSettings',
                //'scenario' => 'site',	// Change if you want to re-use the model for multiple setting form.
                'viewName' => 'settings'	// The form we need to render
            ],
        ];
    }
    public function beforeAction($action) 
    {
        if ($action->id === '0d0dfb2682192387a2e4325e97b36b32') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $params = [
            'call_id' => '1525425018.3415344',
        ];
        $zadarma    = new ZadarmaAPI(Yii::$app->settings->get('ZadarmaSettings.key'), Yii::$app->settings->get('ZadarmaSettings.secret'));
        //$answer     = $zadarma->call('/v1/sms/send/', $params, 'post');
        $balance    = json_decode($zadarma->call('/v1/info/balance/'));
        //$call       = $zadarma->call('/v1/request/callback/', $params);
        $record = json_decode($zadarma->call('/v1/pbx/record/request/', $params, 'get'));
        $searchModel = new ZadarmaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'balance'       => $balance,
            //'call' => $call,
            'record' => $record,
        ]);
    }

    /**
     * Получаем аудиозапись
     */
    public function actionGetRecord() 
    {
        $request = Yii::$app->getRequest();
        if ($request->isPost && $request->isAjax) {            
            $zadarma = new ZadarmaAPI(Yii::$app->settings->get('ZadarmaSettings.key'), 
                    Yii::$app->settings->get('ZadarmaSettings.secret'));
            $audio = json_decode($zadarma->call('/v1/pbx/record/request/', 
                    ['call_id' => $request->post('call_id')], 'get'));
            if ($audio->status == 'success'){
                return $audio->link;
            }
        }
        return 'false';
    }
    
    /**
     * Уведомления о звонках
     * Функция записывает данные о звонках, которые совершаются через телефонию Zadarma
     */
    public function action0d0dfb2682192387a2e4325e97b36b32() 
    {
        $request = Yii::$app->getRequest();
        //проверочный код для подтверждения скрипта задармой
        if (null !== $request->get('zd_echo')) { exit($request->get('zd_echo')); }
        
        if ($request->isPost) {
            // высчитываем подпись
//            $signatureTest = $request->post('destination')
//            // при исходящих звонках
//            ? base64_encode(hash_hmac('sha1', $request->post('internal') . $request->post('destination')  
//                    . $request->post('call_start'), Yii::$app->settings->get('ZadarmaSettings.secret')))
//            // при входящих звонках
//            : base64_encode(hash_hmac('sha1', $request->post('caller_id') . $request->post('called_did')
//                    . $request->post('call_start'), Yii::$app->settings->get('ZadarmaSettings.secret')));
//            $signature = $request->headers->get('signature');  
//            if ($signature == $signatureTest) {
                if (in_array($request->post('event'), ['NOTIFY_START', 'NOTIFY_INTERNAL'])) { $type = 'Входящий'; }        //начало входящего звонка в АТС
                //if ($request->post('event') == 'NOTIFY_INTERNAL') { $type = 'in'; }     //начало входящего звонка на внутренний номер АТС
                if ($request->post('event') == 'NOTIFY_OUT_START') { $type = 'Исходящий'; }     //начало исходящего звонка с АТС
                if (isset($type)){
                    $model = new Zadarma();
                    $params = [
                        'type'          => $type,
                        'call_start'    => time(),
                        'pbx_call_id'   => $request->post('pbx_call_id'),
                        'destination'   => $request->post('destination') ?                  //destination - номер, на который позвонили (при исходящем звонке)
                            $request->post('destination') : $request->post('called_did'),   //called_did  – номер, на который позвонили (при входящем звонке)
                        'internal'      => $request->post('internal') ?                     //internal    - внутренний номер (при исходящем звонке)
                            $request->post('internal') : $request->post('caller_id')        //caller_id   - внутренний номер (при входящем звонке)
                    ];
                    $model->attributes = $params;
                }
                if ($request->post('event') == 'NOTIFY_ANSWER') { //ответ при звонке на внутренний или на внешний номер.
                    $model = Zadarma::findOne(['pbx_call_id' => $request->post('pbx_call_id')]);
                    $model->answer_time = time();
                }
                if(in_array($request->post('event'), ['NOTIFY_END', 'NOTIFY_OUT_END'])){    //конец входящего/исходящего звонка
                    // при завершенном звонке у нас появляются дополнительная информация о вызове
                    $rus_disposition = [ //состояние звонка
                        'answered' => 'разговор',
                        'busy' => 'занято',
                        'cancel' => 'отменен',
                        'no answer' => 'без ответа',
                        'failed' => 'не удался',
                        'no money' => 'нет средств, превышен лимит',
                        'unallocated number' => 'номер не существует',
                        'no limit' => 'превышен лимит',
                        'no day limit' => 'превышен дневной лимит',
                        'line limit' => 'превышен лимит линий',
                        'no money, no limit' => 'превышен лимит',
                    ];
                    $params = [
                        'call_end'          => time(),
                        'disposition'       => array_key_exists($request->post('disposition'), $rus_disposition) 
                            ? $rus_disposition[$request->post('disposition')] : '',
                        'status_code'       => $request->post('status_code'), // код статуса звонка Q.931
                        'is_recorded'       => $request->post('is_recorded'),
                        'call_id_with_rec'  => $request->post('call_id_with_rec'),
                        'duration'          => $request->post('duration'),
                    ];
                    $model= Zadarma::findOne(['pbx_call_id' => $request->post('pbx_call_id')]);
                    $model->attributes = $params;
                }
                $model->save();
            }
//        }
    }
}