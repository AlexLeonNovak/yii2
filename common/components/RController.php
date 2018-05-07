<?php
/**
 * Created by PhpStorm.
 * User: dimav
 * Date: 07.05.2018
 * Time: 12:36
 */

namespace common\components;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;


class RController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow'   => true,
                    ],
                    [
                        'actions' => [],
                        'allow'   => true,
                        'roles'   => RDBManager::getCanToActions(Yii::$app->controller->module->id, Yii::$app->controller->id, Yii::$app->controller->action->id), // --- тут указываем коды ролей, которые имеют доступ к контроллеру ---
                    ],
                ],
            ],
        ];
    }
}