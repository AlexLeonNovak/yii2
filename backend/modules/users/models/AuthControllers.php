<?php

namespace backend\modules\users\models;

use Yii;

/**
 * This is the model class for table "{{%auth_controllers}}".
 *
 * @property int $id
 * @property int $id_module
 * @property string $name
 * @property string $description
 *
 * @property AuthActions[] $authActions
 * @property AuthModules $module
 */
class AuthControllers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_controllers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_module', 'name'], 'required'],
            [['id_module'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
            [['id_module'], 'exist', 'skipOnError' => true, 'targetClass' => AuthModules::className(), 'targetAttribute' => ['id_module' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_module' => 'ID Модуля',
            'name' => 'Имя контроллера',
            'description' => 'Описание контроллера',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthActions()
    {
        return $this->hasMany(AuthActions::className(), ['id_controller' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(AuthModules::className(), ['id' => 'id_module']);
    }
}
