<?php
namespace backend\modules\users\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $id_group;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким логином уже зарегистрирован.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким адресом электронной почты уже существует.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['id_group', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() 
    {
        return [
            'username' => 'Логин',
            'email' => 'Электронная почта',
            'id_group' => 'Должность',
            'password' => 'Пароль',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->id_group = $this->id_group;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
