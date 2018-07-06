<?php
namespace backend\modules\users\models;

use common\models\User;

class UserChangePassword extends User
{
    public $password;
    public $password_repeat;
    
    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Введенные пароли не совпадают'],
        ];
    }
    
    public function attributeLabels() 
    {
        return [
            'password'  => 'Пароль',
            'password_repeat' => 'Повтор пароля',
        ];
    }
    public function resetPassword()
    {
        $this->setPassword($this->password);

        return $this->save(false);
    }
    
}