<?php

namespace backend\modules\testusers\models;

use Yii;
use common\models\User;

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
class UserAswer extends \yii\db\ActiveRecord
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
            [['id_user', 'id_question', 'id_answer', 'id_timestamp'], 'required'],
            [['id_user', 'id_question', 'id_answer', 'id_timestamp'], 'integer'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_answer'], 'exist', 'skipOnError' => true, 'targetClass' => Answers::className(), 'targetAttribute' => ['id_answer' => 'id']],
            [['id_question'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::className(), 'targetAttribute' => ['id_question' => 'id']],
            [['id_timestamp'], 'exist', 'skipOnError' => true, 'targetClass' => Timestamp::className(), 'targetAttribute' => ['id_timestamp' => 'id']],
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
            'id_timestamp' => 'ID timestamp',
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
        return $this->hasOne(Answers::className(), ['id' => 'id_answer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Questions::className(), ['id' => 'id_question']);
    }
    
    public function getTimestamp()
    {
        return $this->hasOne(Timestamp::className(), ['id' => 'id_timestamp']);
    }
}
