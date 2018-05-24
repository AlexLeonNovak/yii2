<?php

namespace backend\modules\users\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "users_contact".
 *
 * @property int $id
 * @property int $id_user
 * @property string $type
 * @property string $value
 *
 * @property User $user
 */
class UsersContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'type', 'value'], 'required'],
            [['id_user'], 'integer'],
            [['type'], 'string', 'max' => 20],
            [['value'], 'string', 'max' => 150],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Сотрудник',
            'type' => 'Тип контакта',
            'value' => 'Значение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
    
    public function getTypes() 
    {
        return $this->select('type')->column();
    }
}
