<?php


namespace backend\modules\testusers\models;

use Yii;
/**
 * Description of TestMsg
 *
 * @author novak-ol
 */
class TestMsg extends \yii\base\Model {
    public $msgWarning, $msgViolation;
    public function rules()
    {
            return [
                    [['msgWarning', 'msgViolation'], 'string'],
            ];
    }

    public function fields()
    {
            return ['msgWarning', 'msgViolation'];
    }
    
    public function attributes()
    {
            return ['msgWarning', 'msgViolation'];
    }
    
    public function attributeLabels()
    {
            return [
                'msgWarning' => 'Предупреждение перед прохождением теста', 
                'msgViolation' => 'Предупреждение при нарушении прохождения теста'
            ];
    }
}
