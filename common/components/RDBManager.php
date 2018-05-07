<?php
/**
 * Created by PhpStorm.
 * User: dimav
 * Date: 07.05.2018
 * Time: 14:17
 */

namespace common\components;
use yii\rbac\DbManager;
use Yii;


class RDBManager extends DbManager
{

    static public function getCanToActions($modul, $controller, $action){

        // --- ищем код записи (наша активность) модуль/контроллер/екшен ---
        $id_user = Yii::$app->user->identity->id;

        // --- смотрим или у юзера это разрешено ---

        // --- если есть в массиве то возвращаем его название роли ---
        return ['admin1'];

        // --- иначе возвращаем ерунду в массиве [false] ---
    }

}