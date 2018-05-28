<?php

namespace backend\modules\users\models;

use Yii;

/**
 * This is the model class for table "users_group".
 *
 * @property int $id
 * @property string $name
 *
 * @property TestThemes[] $testThemes
 * @property User[] $users
 */
class UsersGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Должности сотрудников',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getTestThemes()
//    {
//        return $this->hasMany(TestThemes::className(), ['id_group' => 'id']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_group' => 'id']);
    }
    
    /**
     * @return Array
     */
    public function getUsersGroupArray()
    {
        return $this->find()->asArray()->all();    
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestThemesUsersGroups()
    {
        return $this->hasMany(TestThemesUsersGroup::className(), ['id_group' => 'id']);
    }
}
