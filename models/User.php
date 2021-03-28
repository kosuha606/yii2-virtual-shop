<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property $username
 * @property $email
 * @property $password
 * @property $authKey
 * @property $accessToken
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'username',
                    'email'
                ],
                'required',
            ],
            [
                [
                    'password',
                    'authKey',
                    'accessToekn',
                    'personalDiscount',
                ],
                'safe'
            ],
            ['password', 'toHash']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = self::findOne(['id' => $id]);

        return $user ?: null;
    }

    public function toHash(): void
    {
        $this->password = Yii::$app->security->generatePasswordHash($this->password);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        return self::findOne(['accessToken' => $token]);
    }

    /**
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username): ?User
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    /**
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     * @throws \yii\base\Exception
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}
