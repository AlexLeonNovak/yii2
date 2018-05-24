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
                        'actions' => ['login', 'error', 'request-password-reset'],
                        'allow'   => true,
                    ],
                    [
                        'allow'   => true,
                        'roles'   => Yii::$app->authManager->getCanToActions() // --- тут указываем коды ролей, которые имеют доступ к контроллеру ---
                    ],
                    [
                        'actions' => ['logout', 'reset-password'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'roles'   => ['admin'],
                    ],
                ],
            ],
        ];
    }
}