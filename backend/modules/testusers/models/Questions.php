<?php

namespace backend\modules\testusers\models;

use Yii;

/**
 * This is the model class for table "test_questions".
 *
 * @property int $id
 * @property int $id_test
 * @property string $question
 *
 * @property TestAnswers[] $testAnswers
 * @property Test $test
 * @property TestUserAswer[] $testUserAswers
 */
class Questions extends \yii\db\ActiveRecord
{
    public $test_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_test', 'question'], 'required'],
            [['id_test'], 'integer'],
            [['question'], 'string', 'max' => 255],
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
            'question' => 'Вопрос',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answers::className(), ['id_question' => 'id']);
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
    public function getTheme()
    {
        return $this->hasOne(Themes::className(), ['id' => 'id_theme'])->via('test');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAnswers()
    {
        return $this->hasMany(UserAnswer::className(), ['id_question' => 'id']);
    }
}
