<?php


namespace app\models;


use yii\base\Model;
use app\models\User;

class CreateUser extends Model
{
    public $username;
    public $email;
    public $password;
    public $role;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Это Имя уже занято.'],

            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот Email уже занят.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 5],

            ['role', 'required'],
            ['role', 'in', 'range' => [User::ROLE_ADMIN, User::ROLE_MANAGER, User::ROLE_OPERATOR, User::ROLE_MASTER, User::ROLE_DEFAULT]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'email' => 'Email',
            'role' => 'Права пользователя'
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
        $user->role = $this->role;
        $user->status = $user::STATUS_ACTIVE;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}