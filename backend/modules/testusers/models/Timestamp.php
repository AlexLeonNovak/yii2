<?php

namespace backend\modules\testusers\models;

use Yii;
use common\models\User;
use backend\modules\users\models\UsersGroup;

/**
 * This is the model class for table "test_timestamp".
 *
 * @property int $id
 * @property int $id_theme_test
 * @property int $timestamp
 * @property boolean $for
 *
 * @property Test $test
 * @property Theme $theme
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
            [['id_theme_test', 'timestamp'], 'required'],
            [['id_theme_test', 'timestamp'], 'integer'],
            //[['id_theme_test'], 'exist', 'skipOnError' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'for' => '0-test 1-theme',
            'id_theme_test' => 'Тема или тест', //ID theme or ID Test
            'timestamp' => 'Дата и время прохождения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThemeOrTest()
    {
        if ($this->for){
            return $this->hasOne(Themes::className(), ['id' => 'id_theme_test']);
        } else {
            return $this->hasOne(Test::className(), ['id' => 'id_theme_test']);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAnswers()
    {
        return $this->hasMany(UserAnswer::className(), ['id_timestamp' => 'id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user'])->via('userAnswers');
    }
    
    public function getAnswer()
    {
        return $this->hasOne(Answers::className(), ['id' => 'id_answer'])->via('userAnswers');
    }
    
    public function getAnswers()
    {
        return $this->hasMany(Answers::className(), ['id' => 'id_answer'])->via('userAnswers');
    }
    
    public function getQuestions()
    {
        return $this->hasMany(Questions::className(), ['id' => 'id_question'])->via('userAnswers');
    }
    
    public function getAnswersCorrectCount() 
    {
        return $this->hasMany(Answers::className(), ['id' => 'id_answer'])->where(['correct' => '1'])
                ->via('userAnswers')->count();
    }
//    public function getAnswersIncorrectCount() 
//    {
//        return $this->hasMany(UserAnswer::className(), ['id_timestamp' => 'id'])//->where(['correct' => '0'])
//                ->count();// - $this->getAnswersCorrectCount();
//    }
    public function getUsersGroup() {
        return $this->hasOne(UsersGroup::className(), ['id' => 'id_group'])->via('user');
    }
}
