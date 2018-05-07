<?php

namespace backend\modules\testusers\models;

use Yii;
use backend\modules\users\models\UsersGroup;

/**
 * This is the model class for table "test_settings".
 *
 * @property int $id
 * @property int $id_group
 * @property int $timer
 *
 * @property UsersGroup $group
 */
class TestSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_group', 'timer'], 'required'],
            [['id_group', 'timer'], 'integer'],
            [['id_group'], 'exist', 'skipOnError' => true, 'targetClass' => UsersGroup::className(), 'targetAttribute' => ['id_group' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_group' => 'Должность',
            'timer' => 'Время (с.)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(UsersGroup::className(), ['id' => 'id_group']);
    }
}
