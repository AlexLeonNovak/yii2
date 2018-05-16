<?php

namespace backend\modules\users\models;

use Yii;

/**
 * This is the model class for table "{{%auth_actions}}".
 *
 * @property int $id
 * @property int $id_controller
 * @property string $name
 * @property string $description
 *
 * @property AuthControllers $controller
 */
class AuthActions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_actions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_controller', 'name'], 'required'],
            [['id_controller'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
            [['id_controller'], 'exist', 'skipOnError' => true, 'targetClass' => AuthControllers::className(), 'targetAttribute' => ['id_controller' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_controller' => 'ID Контроллера',
            'name' => 'Действие',
            'description' => 'Описание действия',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getController()
    {
        return $this->hasOne(AuthControllers::className(), ['id' => 'id_controller']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(AuthModules::className(), ['id' => 'id_module'])->via('controller');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModuleControllerAction()
    {
        return $this->module->name . '/' . $this->controller->name . '/' . $this->name;
    }
}
