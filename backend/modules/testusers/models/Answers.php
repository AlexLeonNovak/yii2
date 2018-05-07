<?php

namespace backend\modules\testusers\models;

use Yii;

/**
 * This is the model class for table "test_answers".
 *
 * @property int $id
 * @property int $id_question
 * @property string $answer
 * @property int $correct
 *
 * @property TestQuestions $question
 * @property TestUserAswer[] $testUserAswers
 */

class Answers extends \yii\db\ActiveRecord
{
    public $answers;
    public $corrects;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_question', 'answer'], 'required'],
            [['id_question'], 'integer'],
            [['answer'], 'string', 'max' => 255, 'min' => 1],
            [['correct'], 'boolean', 'trueValue' => true, 'falseValue' => false],
            [['id_question'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::className(), 'targetAttribute' => ['id_question' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_question' => 'Id Question',
            'answer' => 'Текст ответа',
            'correct' => 'Верный ответ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Questions::className(), ['id' => 'id_question']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestUserAswers()
    {
        return $this->hasMany(UserAswer::className(), ['id_answer' => 'id']);
    }
}
