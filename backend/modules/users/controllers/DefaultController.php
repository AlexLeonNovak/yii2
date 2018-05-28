<?php

namespace backend\modules\users\controllers;

use common\components\RController;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\User;
use Yii;
use backend\modules\users\models\AuthActions;
use backend\modules\users\models\AuthActionsSearch;
use backend\modules\users\models\AuthControllers;
use backend\modules\users\models\AuthModules;

/**
 * Default controller for the `users` module
 */
class DefaultController extends RController
{
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions'   => ['modal', 'list'],
                            'allow'     => true,
                            'roles'     => ['@'],
                        ],
                    ],
                ]
            ]
        );
    }
    /**
     * Справочник модуль-контроллер-действие
     */
    public function actionIndex()
    {
        $searchModel = new AuthActionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]);
    }
    
    public function actionModal($id)
    {
        $ids_user = Yii::$app->authManager->getUserByActionId($id);
        $user_list = ArrayHelper::map(User::find()->all(), 'id', 'fullName');
        if (Yii::$app->request->isAjax){
            $model = AuthActions::findOne($id);
            return $this->renderAjax('_modal-form',[
                'model' => $model,
                'ids_user' => $ids_user,
                'user_list' => $user_list,
            ]);
        }
        if (Yii::$app->request->isPost) {
            foreach ($user_list as $id_user => $name){
                if (null != Yii::$app->request->post('ids') && 
                        in_array($id_user, Yii::$app->request->post('ids'))){
                    Yii::$app->authManager->setActionToUser($id, $id_user);
                } else {
                    Yii::$app->authManager->deleteActionByUser($id, $id_user);
                }
            }
            $this->redirect('index');
        }
    }
    
    /**
     * Создаем новую запись
     */
    public function actionCreate() 
    {
        $request = Yii::$app->getRequest();
        if ($request->isPost){
            $paramModules = $request->post()['AuthModules'];
            $paramControllers = $request->post()['AuthControllers'];
            $paramActions = $request->post()['AuthActions'];
            if (!$paramModules['id']){
                $modelModules = AuthModules::findOne(['name' => $paramModules['name']]);
                if ($modelModules){
                    $paramModules['id'] = $modelModules->id;
                } else {
                    $modelModules = new AuthModules();
                    $modelModules->load($request->post());
                    $modelModules->save();  
                }
            }
            if (!$paramControllers['id']){
                $modelControllers = AuthControllers::findOne([
                        'name' => $paramControllers['name'],
                        'id_module' => $paramModules['id'] ? $paramModules['id'] : $modelModules->id
                    ]);
                if ($modelControllers) {
                    $paramControllers['id'] = $modelControllers->id;
                } else {
                    $modelControllers = new AuthControllers();
                    $modelControllers->load($request->post());
                    $modelControllers->id_module = $paramModules['id'] 
                            ? $paramModules['id'] : $modelModules->id;
                    $modelControllers->save();
                }
            }
            if (!$paramActions['id']){
                $modelActions = AuthActions::findOne([
                        'name' => $paramActions['name'],
                        'id_controller' => $paramControllers['id'] ? $paramControllers['id'] : $modelControllers->id
                    ]);
                if (!$modelActions){
                    $modelActions = new AuthActions();
                    $modelActions->load($request->post());
                    $modelActions->id_controller = $paramControllers['id'] 
                            ? $paramControllers['id'] : $modelControllers->id;
                    $modelActions->save();
                    Yii::$app->session->setFlash('success', 'Действие сохранено');
                }
            } else {
                Yii::$app->session->setFlash('danger', 'Ошибка сохранения!');
            }
        }
        $modelModules = new AuthModules();
        $modelControllers = new AuthControllers();
        $modelActions = new AuthActions();
        return $this->render('create', [
            'modelActions'      => $modelActions,
            'modelControllers'  => $modelControllers,
            'modelModules'      => $modelModules,
        ]);
    }
    
    public function actionUpdate ($id)
    {
        $modelActions = AuthActions::findOne($id);
        $modelControllers = AuthControllers::findOne($modelActions->id_controller);
        $modelModules = AuthModules::findOne($modelControllers->id_module);
        $request = Yii::$app->getRequest();
        if ($request->isPost){
            $modelModules->load($request->post());
            $modelControllers->load($request->post());
            $modelActions->load($request->post());
            if ($modelActions->save() && $modelControllers->save() && $modelModules->save()) {
                Yii::$app->session->setFlash('success', 'Изменения сохранены');
                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('danger', 'Ошибка сохранения!');
            }
        }
        return $this->render('update', [
            'modelActions'      => $modelActions,
            'modelControllers'  => $modelControllers,
            'modelModules'      => $modelModules,
        ]);
    }
    
    /**
     * Подгрузка автозаполнения
     * @param string $term Строка поиска
     * @param int $id_module
     * @param int $id_controller
     * @return json
     */
    public function actionList($term, $id_module = null, $id_controller = null)
    {
        if ($id_module) {
            return json_encode(AuthControllers::find()
                ->select(['name as label', 'id', 'description', 'id_module'])
                ->where(['id_module' => $id_module])
                ->andFilterWhere(['like', 'name', $term])
                ->asArray()->all());
        }
        if ($id_controller) {
            return json_encode(AuthActions::find()
                ->select(['name as label', 'id', 'description', 'id_controller'])
                ->where(['id_controller' => $id_controller])
                ->andFilterWhere(['like', 'name', $term])
                ->asArray()->all());
        }
        return false;
    }
}
