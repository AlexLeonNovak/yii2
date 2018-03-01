<?php

namespace app\modules\testusers\models;

use Yii;

/**
 * This is the model class for table "test_user_aswer".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_question
 * @property int $id_answer
 *
 * @property User $user
 * @property TestAnswers $answer
 * @property TestQuestions $question
 */
class TestUserAswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_user_aswer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_question', 'id_answer'], 'required'],
            [['id_user', 'id_question', 'id_answer'], 'integer'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_answer'], 'exist', 'skipOnError' => true, 'targetClass' => TestAnswers::className(), 'targetAttribute' => ['id_answer' => 'id']],
            [['id_question'], 'exist', 'skipOnError' => true, 'targetClass' => TestQuestions::className(), 'targetAttribute' => ['id_question' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_question' => 'Id Question',
            'id_answer' => 'Id Answer',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(TestAnswers::className(), ['id' => 'id_answer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(TestQuestions::className(), ['id' => 'id_question']);
    }
}
