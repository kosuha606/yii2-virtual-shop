<?php

namespace app\forms;

use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;

    public $email;

    public $password;

    public $repeatPassword;

    public function rules()
    {
        return [
            [
                [
                    'username',
                    'email',
                    'password',
                    'repeatPassword',
                ],
                'required'
            ],
            ['email', 'email'],
            ['password', 'sameAsRepeat']
        ];
    }

    public function sameAsRepeat()
    {
        if ($this->password !== $this->repeatPassword) {
            $this->addError('Пароли не совпадают');
        }
    }
}