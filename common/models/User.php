<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\modules\users\models\UsersGroup;
use backend\modules\users\models\UsersContact;
use backend\modules\users\models\UsersInfo;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property date $dateOfBirth Y-m-d
 * @property string $firstName
 * @property string $middleName
 * @property string $lastName
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    //public $dateOfBirth;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['id_group'], 'exist', 'skipOnError' => true, 'targetClass' => UsersGroup::className(), 'targetAttribute' => ['id_group' => 'id']],
            [['firstName', 'middleName', 'lastName', 'worktime_start', 'worktime_end'], 'string', 'max' => 50],
//            [['dateOfBirth'], 'date', 'format' => 'yyyy-mm-dd'],
            [['dateOfBirth'], 'validateDateOfBirth']
        ];
    }

    public function validateDateOfBirth($attribute)
    {
        $date = \DateTime::createFromFormat('d.m.Y', $attribute);
        $errors = \DateTime::getLastErrors();
        if (!empty($errors['warning_count'])) {
            $this->addError($attribute, 'Неверная дата');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() 
    {
        return [
            'username'      => 'Логин',
            'email'         => 'Электронная почта',
            'id_group'      => 'Должность',
            'status'        => 'Статус',
            'firstName'     => 'Имя',
            'middleName'    => 'Отчество',
            'lastName'      => 'Фамилия',
            'dateOfBirth'   => 'Дата рождения',
            'fullName'      => 'ФИО',
            'fullNameInitials' => 'ФИО',
            'created_at'    => 'Зарегистрирован',
            'updated_at'    => 'Обновление данных',
            'worktime_start'=> 'worktime_start',
            'worktime_end'  => 'worktime_end'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    
    public static function getCurrentUserGroupId(){
        
        $user_group = static::find()->where(['id' => Yii::$app->user->identity->id])->one();
        return $user_group->id_group;
    }
    
    public static function getUserListArray() 
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'fullName', 'usersGroup.name');
    }
    
    public function getUsersGroup()
    {
        return $this->hasOne(UsersGroup::className(), ['id' => 'id_group']);
    }
    
    public function getFullName()
    {
        return $this->lastName 
                ? $this->lastName . ' ' 
                . $this->firstName
                . ($this->middleName ? ' ' . $this->middleName : '')
                : $this->username;
    }
    
    public function getFullNameInitials() 
    {
        return $this->lastName 
                ? $this->lastName . ' '
                . StringHelper::truncate($this->firstName, 1, '.') 
                . ($this->middleName ? ' ' . StringHelper::truncate($this->middleName, 1, '.') : '')
                : $this->username;
    }
    
    public function getContacts() 
    {
        return $this->hasMany(UsersContact::className(), ['id_user' => 'id']);
        
    }
    
        
    public function getInfos() 
    {
        return $this->hasMany(UsersInfo::className(), ['id_user' => 'id']);
        
    }
    
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
