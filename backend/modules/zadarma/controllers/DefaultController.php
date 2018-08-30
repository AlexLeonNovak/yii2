<?php

namespace backend\modules\zadarma\controllers;

use Yii;
use common\components\RController;
use backend\modules\zadarma\components\ZadarmaAPI;
use yii\filters\AccessControl;
use backend\modules\zadarma\models\Zadarma;
use backend\modules\zadarma\models\ZadarmaSearch;
use yii\helpers\ArrayHelper;
use common\models\User;
use backend\modules\users\models\UsersContact;
use yii\db\Query;
use yii\helpers\VarDumper;
use yii\filters\Cors;

/**
 * Default controller for the `zadarma` module
 */
class DefaultController extends RController
{
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge([
                [
                    'class' => Cors::className(),
                    'cors' => [
                        'Origin' => ['https://crm.czholding.ru', 'https://praga-crm.loc'],
                        'Access-Control-Request-Method' => ['POST'],
                        'Access-Control-Request-Headers' => ['*'],
                    ],
//                    'actions' => [
//                        'get-record' => [
//                            'Access-Control-Allow-Credentials' => true,
//                        ]
//                    ]
                ],
            ],
                parent::behaviors(), 
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                            [
                                'actions' => ['0d0dfb2682192387a2e4325e97b36b32', 'get-record'],
                                'allow' => true,
                            ],
//                            [
//                                'actions' => ['get-record'],
//                                'allow' => true,
//                                'roles' => ['@'],
//                            ],
                        ],
                    ],
                ]
            );
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
        if (in_array($action->id, ['0d0dfb2682192387a2e4325e97b36b32', 'get-record'])) {
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
        $usersContactArray = ArrayHelper::map(UsersContact::findAll(['type' => 'zadarma']), 'value', 'user.fullNameInitials');
        $zadarma = new ZadarmaAPI(Yii::$app->settings->get('ZadarmaSettings.key'), Yii::$app->settings->get('ZadarmaSettings.secret'));
        $balance = json_decode($zadarma->call('/v1/info/balance/'));
        $searchModel = new ZadarmaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel'       => $searchModel,
            'dataProvider'      => $dataProvider,
            'balance'           => $balance,
            'usersContactArray' => $usersContactArray,
        ]);
    }

    /**
     * Получаем аудиозапись
     */
    public function actionGetRecord() 
    {
        $request = Yii::$app->getRequest();
        if ($request->isPost) {            
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
                if ($request->post('event') == 'NOTIFY_START')     { $type = 'Входящий';  }     //начало входящего звонка в АТС
                if ($request->post('event') == 'NOTIFY_OUT_START') { $type = 'Исходящий'; }     //начало исходящего звонка с АТС
                if (isset($type)){
                    $model = new Zadarma();
                    $params = [
                        'type'          => $type,
                        'call_start'    => time(),
                        'pbx_call_id'   => $request->post('pbx_call_id'),
                        'destination'   => $request->post('destination') ?                  //destination - номер, на который позвонили (при исходящем звонке)
                            $request->post('destination') : $request->post('called_did'),   //called_did  – номер, на который позвонили (при входящем звонке)
                        'internal'      => $request->post('internal'),                     //internal    - внутренний номер (при исходящем звонке)
                        'caller_id'     => $request->post('caller_id'),        //caller_id   - внутренний номер (при входящем звонке)
                    ];
                    $model->attributes = $params;
                } else {
                    $model = Zadarma::findOne(['pbx_call_id' => $request->post('pbx_call_id')]);
                }
                if ($request->post('event') == 'NOTIFY_INTERNAL') {  //начало входящего звонка на внутренний номер АТС
                    if (!empty($model->internal)){
                        $internal = explode(',', $model->internal);
                    }
                    $internal[] = $request->post('internal');
                    $model->internal = implode(',', $internal);
                }    
                if ($request->post('event') == 'NOTIFY_ANSWER') { //ответ при звонке на внутренний или на внешний номер.
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
                    if (empty($model->answer_time)){
                        $model->answer_time = time();
                    }
                    $params = [
                        'call_end'          => time(),
                        'disposition'       => array_key_exists($request->post('disposition'), $rus_disposition) 
                            ? $rus_disposition[$request->post('disposition')] : '',
                        'status_code'       => $request->post('status_code'), // код статуса звонка Q.931
                        'is_recorded'       => $request->post('is_recorded'),
                        'call_id_with_rec'  => $request->post('call_id_with_rec'),
                        'duration'          => $request->post('duration'),
                    ];
                    $model->attributes = $params;
                }
                $model->save();
                //переносим данные в старую БД
                if ($model->type === 'Исходящий'){
                    $this->saveInOldDB($model);
                }  
            } else {
                echo 'Zadarma request must been a POST';
            }
//        }
    }
    
    public function saveInOldDB($model)
    {
        $userContact = UsersContact::findOne([
                    'type' => 'zadarma',
                    'value' => $model->internal,
                ]);
        //поиск ид юзера и статус работы плагина по его логину в старой БД
        $id_user_o = (new Query())->from('users')
                ->select(['id', 'plugin_is_started'])
                ->where(['login' => $userContact->user->username])
                ->one(Yii::$app->oldDB);
             VarDumper::dump($id_user_o);        
        // ищем последний отчет
        $last_report = (new Query)->from('report_real')
                ->where(['user' => $id_user_o['id']])
                ->andWhere(['!=', 'h2', 0])
                ->orderBy('id DESC')
                ->one(Yii::$app->oldDB);
        //ищем ид клиента по номеру телефона
        $id_client_o = (new Query)->from('future_client')
                ->select('id')
                ->where([
                    'or',
                    ['like', 'phone', $model->destination],
                    ['like', 'phone2', $model->destination],
                    ['like', 'phone3', $model->destination],
                    ['like', 'phone4', $model->destination],
                    ['like', 'phone5', $model->destination],
                    ['like', 'phone6', $model->destination],
                ])
                ->one(Yii::$app->oldDB);
        $lr_m = $last_report['m2'] ?? '00';
        $lr_s = $last_report['s2'] ?? '00';
        (new Query())->createCommand(Yii::$app->oldDB)
                ->insert('report_real', [
                    'date'      => $last_report['date'],
                    'user'      => $id_user_o['id'],
                    'pay'       => 'on',
                    'h1'        => $last_report['h2'],
                    'm1'        => $lr_m,
                    's1'        => $lr_s,
                    'h2'        => date('H'),
                    'm2'        => date('i'),
                    's2'        => date('s'),
                    'minutes'   => $id_user_o['plugin_is_started'] ? 0 : ((strtotime(date('H:i:s')) 
                        - strtotime($last_report['h2'].':'.$lr_m.':'.$lr_s))/60),
                    'action'    => 956,
                    'client'    => $id_client_o['id'],
                    'text'      => 'Исходящий звонок Zadarma',
                ])
                ->execute();
    }
    
}
