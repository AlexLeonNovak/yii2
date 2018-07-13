<?php

namespace backend\modules\testusers\models;

use Yii;
use common\models\User;
use backend\modules\users\models\UsersGroup;
use yii\helpers\ArrayHelper;

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
    const THEME = 1;
    const TEST  = 0;
    const VIOLATION_TRUE = 1;
    const VIOLATION_FALSE = 0;
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
            'id'            => 'ID',
            'for'           => '0-test 1-theme',
            'id_theme_test' => 'Тема или тест', //ID theme or ID Test
            'timestamp'     => 'Дата и время прохождения',
            'totaltime'     => 'Общее время затраченное на тестирование',
            'violation'     => 'Нарушение'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThemeOrTest()
    {
        if ($this->for == self::THEME){
            return $this->hasOne(Themes::className(), ['id' => 'id_theme_test']);
        } else {
            return $this->hasOne(Test::className(), ['id' => 'id_theme_test']);
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThemesOrTests()
    {
        if ($this->for == self::THEME){
            return $this->hasMany(Themes::className(), ['id' => 'id_theme_test']);
        } else {
            return $this->hasMany(Test::className(), ['id' => 'id_theme_test']);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAnswers()
    {
        return $this->hasMany(UserAnswer::className(), ['id_timestamp' => 'id']);
    }
    public function getUserAnswersCount()
    {
        return count(ArrayHelper::index($this->hasMany(UserAnswer::className(), ['id_timestamp' => 'id'])->asArray()->all(), 'id_question'));
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
        $correct    = $this->hasMany(Answers::className(), ['id' => 'id_answer', 'id_question' => 'id_question']) 
                        ->where(['correct' => '1'])->via('userAnswers')->asArray()->all();
        $incorrect  = $this->hasMany(Answers::className(), ['id' => 'id_answer', 'id_question' => 'id_question'])
                        ->where(['correct' => '0'])->via('userAnswers')->asArray()->all();
//        $all        = $this->hasMany(Answers::className(), ['id' => 'id_answer', 'id_question' => 'id_question'])
//                        ->via('userAnswers')->asArray()->all();    
        $diff = array_diff_key(ArrayHelper::index($correct, 'id_question'), ArrayHelper::index($incorrect, 'id_question'));
        return count(ArrayHelper::index($diff, 'id'));
    }

    public function getUsersGroup() {
        return $this->hasOne(UsersGroup::className(), ['id' => 'id_group'])->via('user');
    }
    
    /**
     * @param $id_theme_test ИД темы или ИД теста, изходя из параметра $id_theme
     * @param $id_theme Значение указывает что удалять, если false то Тест, по умолчанию Тема
     * @return boolean
     */
    public function deleteUserAnswers($id_theme_test, $id_theme = self::THEME) 
    {
        //ищем запись о прохождении темы или теста
        $ids_test = Test::find()->where(['id_theme' => $id_theme_test])->select('id')->column();

        $ids_timestamp = Timestamp::find()->where([
            'or',
            ['for' => self::THEME, 'id_theme_test' => $id_theme_test],
            ['for' => self::TEST, 'id_theme_test' => $ids_test],
            ])->select('id')->column();
        try {
            UserAnswer::deleteAll(['id_timestamp' => $ids_timestamp]);
            Timestamp::deleteAll(['id' => $ids_timestamp]);
        } catch(\yii\db\Exception $e) {
            return false;
        }
        return true;
    }
}
