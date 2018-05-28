<?php

namespace backend\modules\users\controllers;

use Yii;
use common\models\User;
use backend\modules\users\models\UserSearch;
use backend\modules\users\models\SignupForm;
use yii\web\NotFoundHttpException;
use backend\modules\users\models\UsersGroup;
use yii\data\ActiveDataProvider;
use common\components\RController;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends RController
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
                            'actions'   => ['activate'],
                            'allow'     => true,
                            'roles'     => ['@'],
                        ],
                    ],
                ]
            ]
        );
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //var_dump($searchModel->dateOfBirth);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getContacts(),
        ]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // Приводим дату к пользовательскому формату
//        if ($model->dateOfBirth){
//            $model->dateOfBirth = \DateTime::createFromFormat('Y-m-d', $model->dateOfBirth)->format('d.m.Y');
//        }
//        // Ставим обработчик который после успешной проверки данных в пользовательском формате вернет дату в формат для mysql
//        $model->on(ActiveRecord::EVENT_BEFORE_UPDATE, function () use ($model) {
//            if ($model->dateOfBirth){
//                $model->dateOfBirth = \DateTime::createFromFormat('d.m.Y', $model->dateOfBirth)->format('Y-m-d');
//            }
//        });
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        
        $group = UsersGroup::find()->all();
        return $this->render('update', [
            'model' => $model,
            'group' => $group,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                Yii::$app->session->setFlash('success', 'Сотрудник успешно зарегистрирован');
                return $this->redirect('index');
            }
        }
        $group = UsersGroup::find()->all();
        return $this->render('signup', [
            'model' => $model,
            'group' => $group
        ]);
    }
    
    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        if ($model->status == User::STATUS_ACTIVE){
            $model->status = User::STATUS_DELETED;
        } else {
            $model->status = User::STATUS_ACTIVE;
        }
        $model->save();
        
        return $this->redirect(['index']);
    }
}
