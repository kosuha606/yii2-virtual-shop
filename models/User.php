<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property $username
 * @property $email
 * @property $password
 * @property $authKey
 * @property $accessToken
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public function rules()
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
                ],
                'safe'
            ],
            ['password', 'toHash']
        ];
    }

    /**
     * @throws \yii\base\Exception
     */
    public function toHash()
    {
        $this->password = Yii::$app->security->generatePasswordHash($this->password);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = self::findOne(['id' => $id]);

        return $user ?: null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::findOne(['accessToken' => $token]);

        return $user;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = self::findOne(['username' => $username]);

        return $user;
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
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     * @throws \yii\base\Exception
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}
