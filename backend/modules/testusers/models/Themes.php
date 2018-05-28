<?php

namespace backend\modules\testusers\models;

use Yii;
use \backend\modules\users\models\UsersGroup;

/**
 * This is the model class for table "{{%test_themes}}".
 *
 * @property int $id
 * @property int $id_group
 * @property string $name
 *
 * @property Test[] $tests
 * @property TestThemesUsersGroup[] $testThemesUsersGroups
 */
class Themes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test_themes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_group', 'name'], 'required'],
            [['id_group'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_group'], 'exist', 'skipOnError' => true, 'targetClass' => UsersGroup::className(), 'targetAttribute' => ['id_group' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_group' => 'Основная должность сотрудников',
            'name' => 'Имя темы',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['id_theme' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestThemesUsersGroups()
    {
        return $this->hasMany(TestThemesUsersGroup::className(), ['id_theme' => 'id']);
    }
    
    public function getGroups() 
    {
        return $this->hasMany(UsersGroup::className(), ['id' => 'id_group'])->via('testThemesUsersGroups');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(UsersGroup::className(), ['id' => 'id_group']);
    }
}
