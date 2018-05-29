<?php

namespace backend\modules\users\models;

use Yii;

/**
 * This is the model class for table "{{%auth_modules}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @property AuthControllers[] $authControllers
 */
class AuthModules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_modules}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя модуля',
            'description' => 'Описание модуля',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthControllers()
    {
        return $this->hasMany(AuthControllers::className(), ['id_module' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthActions()
    {
        return $this->hasMany(AuthActions::className(), ['id_controller' => 'id'])
                ->viaTable(AuthControllers::tableName(), ['id_module' => 'id']);
    }
}
