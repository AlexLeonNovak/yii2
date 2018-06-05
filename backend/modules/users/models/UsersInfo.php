<?php

namespace backend\modules\users\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "{{%users_info}}".
 *
 * @property int $id
 * @property int $id_user
 * @property string $type
 * @property string $value
 *
 * @property User $user
 */
class UsersInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users_info}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'type', 'value'], 'required'],
            [['id_user'], 'integer'],
            [['value'], 'string'],
            [['type'], 'string', 'max' => 20],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'type' => 'Тип информации',
            'value' => 'Текст',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
