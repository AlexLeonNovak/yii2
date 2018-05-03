<?php


namespace backend\modules\zadarma\models;

use Yii;
/**
 * Description of TestMsg
 *
 * @author novak-ol
 */
class ZadarmaSettings extends \yii\base\Model {
    public $key, $secret;
    public function rules()
    {
            return [
                    [['key', 'secret'], 'string'],
            ];
    }

    public function fields()
    {
            return ['key', 'secret'];
    }
    
    public function attributes()
    {
            return ['key', 'secret'];
    }
    
    public function attributeLabels()
    {
            return [
                'key' => 'Key', 
                'secret' => 'Secret'
            ];
    }
}