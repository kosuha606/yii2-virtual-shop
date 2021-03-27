<?php

namespace app\forms;

use yii\base\Model;

class RegistrationForm extends Model
{
    public ?string $username = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $repeatPassword = null;

    /**
     * @return array
     */
    public function rules(): array
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

    public function sameAsRepeat(): void
    {
        if ($this->password !== $this->repeatPassword) {
            $this->addError('Пароли не совпадают');
        }
    }
}
