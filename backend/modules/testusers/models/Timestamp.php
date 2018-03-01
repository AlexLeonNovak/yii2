<?php

namespace backend\modules\testusers\models;

use Yii;

/**
 * This is the model class for table "test_timestamp".
 *
 * @property int $id
 * @property int $id_test
 * @property int $timestamp
 *
 * @property Test $test
 * @property TestUserAswer[] $testUserAswers
 */
class Timestamp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_timestamp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_test', 'timestamp'], 'required'],
            [['id_test', 'timestamp'], 'integer'],
            [['id_test'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['id_test' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_test' => 'Id Test',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'id_test']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestUserAswers()
    {
        return $this->hasMany(TestUserAswer::className(), ['id_timestamp' => 'id']);
    }
}
