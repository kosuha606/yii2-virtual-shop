<?php

namespace app\virtualModels\Services;


use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\User;

class UserService
{
    /** @var User */
    private $user;

    public function login($userId)
    {
        $user = VirtualModelManager::getInstance()->getProvider()->one(User::class, [
            'where' => [
                ['=', 'id', $userId]
            ]
        ]);
        $this->user = $user;
    }

    public function current()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}