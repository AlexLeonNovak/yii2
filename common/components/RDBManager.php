<?php
/**
 * Created by PhpStorm.
 * User: dimav
 * Date: 07.05.2018
 * Time: 14:17
 */

namespace common\components;
use yii\rbac\DbManager;
use yii\db\Query;
use Yii;


class RDBManager extends DbManager
{
    // таблица с записями модуль/контроллер/екшн
    public $modulesTable = '{{%auth_modules}}';
    public $controllersTable = '{{%auth_controllers}}';
    public $actionsTable = '{{%auth_actions}}';
    // таблица связи юзер-екшн
    public $userActionsTable = '{{%auth_user_actions}}';

    public function getCanToActions(){
        if (Yii::$app->user->isGuest){
            return [false];
        }
        // получаем имена модуль/контроллер/екшн
        $module = Yii::$app->controller->module->id;
        $controller = Yii::$app->controller->id;    
        $action = Yii::$app->controller->action->id;

        // --- ищем код записи (наша активность) модуль/контроллер/екшн ---
        
        $query = new Query();
        $id_action = $query->select($this->actionsTable.'.`id`')
            ->from($this->actionsTable)
            ->leftJoin($this->controllersTable, $this->controllersTable.'.`id` = '.$this->actionsTable.'.`id_controller`')
            ->leftJoin($this->modulesTable, $this->modulesTable.'.`id` = '.$this->controllersTable.'.`id_module`')
            ->where([
                $this->modulesTable.'.`name`' => $module, 
                $this->controllersTable.'.`name`' => $controller,
                $this->actionsTable.'.`name`' => $action])
            ->one($this->db);
        // получаем массив с разрешенными ид екшнами
        if (!$access_array = $this->getAccessArrayActionsByUserId(Yii::$app->user->identity->id)){
            return [false];
        }

        // --- смотрим или у юзера это разрешено ---
        if (in_array($id_action['id'], $access_array)){
            foreach(Yii::$app->authManager->getAssignments(Yii::$app->user->identity->id) as $key => $value){
                $result[] = $key;
            }
            // --- если есть в массиве то возвращаем его название роли ---
            return $result;
        }
        // --- иначе возвращаем ерунду в массиве [false] ---
        return [false];
    }
    
    /**
     * Возвращает все доступные модули для пользователя, если нет - получаем false
     * 
     * @param type $id_user
     * @return boolean
     */
    public function getUserListAccess($id_user) 
    {
        if (!$access_array = $this->getAccessArrayActionsByUserId($id_user)){
            return false;
        }
        $query = new Query();
        return $query->from($this->actionsTable)->select([
                $this->modulesTable.'.`name` as `module_name`',
                $this->modulesTable.'.`description` as `module_description`',
                $this->controllersTable.'.`name` as `controller_name`',
                $this->controllersTable.'.`description` as `controller_description`',
                $this->actionsTable.'.`id`',
                $this->actionsTable.'.`name` as `action_name`',
                $this->actionsTable.'.`description` as `action_description`',
            ])
            ->leftJoin($this->controllersTable, $this->controllersTable.'.`id` = '.$this->actionsTable.'.`id_controller`')
            ->leftJoin($this->modulesTable, $this->modulesTable.'.`id` = '.$this->controllersTable.'.`id_module`')
            ->where([$this->actionsTable.'.`id`' => $access_array])
            ->all($this->db);
    }
    
    /**
     * Получаем массив с ид екшнами для юзера
     * @param int $id_user
     * @return array 
     */
    public function getAccessArrayActionsByUserId($id_user)
    {
        $query = new Query();
        $access_array = $query->select(['ids_actions'])
            ->from($this->userActionsTable)
            ->where(['id_user' => $id_user])
            ->one($this->db);
        if ($access_array){
            return explode(',', $access_array['ids_actions']);
        }
        return false;
    }
    
    /**
     * Получаем юзеров по ид екшна
     * @param int $id_action
     */
    public function getUserByActionId($id_action)
    {
        $query = new Query();
        // получаем все записи из БД
        $all_actions = $query->from($this->userActionsTable)->all($this->db);
        $ids_users = []; // объявляем пустой массив, для записи ид юзеров
        foreach ($all_actions as $action){ // прохрдим по всех записях
            $arr_actions = explode(',', $action['ids_actions']); // получаем массив екшнов
            if (in_array($id_action, $arr_actions)){ // проверяем, есть ли ид екшна в массиве
                $ids_users[] = $action['id_user']; // записываем ид юзеров в массив
            }
        }
        return $ids_users;
    }
    
    /**
     * Запись екшнов для юзера в БД 
     * @param int $id_action
     * @param int $id_user
     * @return boolean
     */
    public function setActionToUser($id_action, $id_user)
    {
        // ищем все екшны доступные юзеру
        $actions = $this->getAccessArrayActionsByUserId($id_user);
        $query = new Query();
        $q = $query->createCommand($this->db);
        if (!$actions){ // если массив пустой, то создаем запись
            $q->insert($this->userActionsTable, [
                    'id_user' => $id_user,
                    'ids_actions' => $id_action
                ])->execute();
            return true;
        }
        // проверяем, есть ли данный ид екшна в массиве доступных
        // если есть, то добавляем, нет - то возвращаем false
        if (!in_array($id_action, $actions)){ 
            $actions[] = $id_action;
            $q->update($this->userActionsTable, 
                ['ids_actions' => implode(',', $actions)],
                ['id_user' => $id_user])
            ->execute();
            return true;
        }
        return false;
    }
    
    /**
     * Удаление екшна из БД
     * @param int $id_action
     * @param int $id_user
     * @return boolean
     */
    public function deleteActionByUser($id_action, $id_user)
    {
        // ищем все екшны доступные юзеру
        $actions = $this->getAccessArrayActionsByUserId($id_user);
        $query = new Query();
        if (!$actions){ //если массив пустой - то удалять нечего
            return false;
        }
        if (in_array($id_action, $actions)){ // проверяем, есть ли данный ид екшна в массиве доступных
            unset($actions[array_search($id_action, $actions)]); // извлекаем из массива этот ид
            if (count($actions)){ // если массив не пустой, то обновляем запись в БД
                $query->createCommand($this->db)
                    ->update($this->userActionsTable,
                        ['ids_actions' => implode(',', $actions)],
                        ['id_user' => $id_user])
                ->execute();
            } else { // иначе удаляем эту запись
                $this->deleteAllActionsByUser($id_user);
            }
            return true;
        }
        return false;
    }
    
    /**
     * Удаление всех екшнов из БД по ид юзера
     * @param int $id_user
     * @return boolean
     */
    public function deleteAllActionsByUser($id_user)
    {
        $query = new Query();
        $query->createCommand($this->db)
            ->delete($this->userActionsTable, [
                    'id_user' => $id_user
                ])->execute();
        return true;
    }
    
}