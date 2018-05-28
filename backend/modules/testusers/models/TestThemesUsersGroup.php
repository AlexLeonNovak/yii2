<?php

namespace backend\modules\testusers\models;

use Yii;
use backend\modules\users\models\UsersGroup;

/**
 * This is the model class for table "{{%test_themes__users_group}}".
 *
 * @property int $id_theme
 * @property int $id_group
 *
 * @property UsersGroup $group
 * @property TestThemes $theme
 */
class TestThemesUsersGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test_themes__users_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_theme', 'id_group'], 'required'],
            [['id_theme', 'id_group'], 'integer'],
            [['id_group'], 'exist', 'skipOnError' => true, 'targetClass' => UsersGroup::className(), 'targetAttribute' => ['id_group' => 'id']],
            [['id_theme'], 'exist', 'skipOnError' => true, 'targetClass' => Themes::className(), 'targetAttribute' => ['id_theme' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_theme' => 'Id Theme',
            'id_group' => 'Id Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(UsersGroup::className(), ['id' => 'id_group']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdsGroup()
    {
        return $this->hasMany(UsersGroup::className(), ['id' => 'id_group'])->select('id')->column();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(TestThemes::className(), ['id' => 'id_theme']);
    }
}
