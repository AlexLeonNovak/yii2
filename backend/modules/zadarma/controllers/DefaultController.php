<?php

namespace backend\modules\zadarma\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\zadarma\components\ZadarmaAPI;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
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
                        'actions' => ['settings', 'index', 'signup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
            'from' => '442037690165',
            'to' => '4444',
           // 'sip' => '976463'
        ];
        $zadarma    = new ZadarmaAPI(Yii::$app->settings->get('ZadarmaSettings.key'), Yii::$app->settings->get('ZadarmaSettings.secret'), true);
        //$answer     = $zadarma->call('/v1/sms/send/', $params, 'post');
        $balance    = json_decode($zadarma->call('/v1/info/balance/'));
        //$call       = $zadarma->call('/v1/request/callback/', $params);
        $searchModel = new ZadarmaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'balance'       => $balance,
            //'call' => $call,
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
            $signatureTest = $request->post('destination')
            // при исходящих звонках
            ? base64_encode(hash_hmac('sha1', $request->post('internal') . $request->post('destination')  
                    . $request->post('call_start'), Yii::$app->settings->get('ZadarmaSettings.secret')))
            // при входящих звонках
            : base64_encode(hash_hmac('sha1', $request->post('caller_id') . $request->post('called_did')
                    . $request->post('call_start'), Yii::$app->settings->get('ZadarmaSettings.secret')));
            $signature = $request->headers->get('signature');  
            if ($signature == $signatureTest) {
                $model = new Zadarma();
                $params['Zadarma'] = $request->post();
                $model->load($params);
                $model->save();
            }
        }
    }
}
