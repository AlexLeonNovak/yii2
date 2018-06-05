<?php
namespace backend\modules\users\models;

use Yii;
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
    public $password_repeat;


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

            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Введенные пароли не совпадают'],
            
            ['id_group', 'integer'],
            ['id_group', 'required', 'message' => 'Необходимо выбрать «{attribute}»'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() 
    {
        return [
            'username'  => 'Логин',
            'email'     => 'Электронная почта',
            'id_group'  => 'Должность',
            'password'  => 'Пароль',
            'password_repeat' => 'Повтор пароля',
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
        if ($user->save()) {
            $role = Yii::$app->authManager->createRole($this->username . $user->id);
            $role->description = $this->username;
            Yii::$app->authManager->add($role);
            Yii::$app->authManager->assign($role, $user->id);
            return $user;
        }
        return null;
    }
}
