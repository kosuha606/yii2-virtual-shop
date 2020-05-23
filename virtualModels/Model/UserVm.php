<?php

namespace app\virtualModels\Model;

use app\virtualModels\Admin\Services\PermissionService;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\ServiceManager;

/**
 * Пользователь
 * @package kosuha606\Model\iteration2\model
 * @property $id
 */
class UserVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'name',
            'email',
            'role',
            'personalDiscount',
            'password',
        ];
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public function isAdmin()
    {
        try {
            ServiceManager::getInstance()->get(PermissionService::class)->ensureActionAvailable('admin.access', $this);
            return true;
        } catch (\Throwable $exception) {
            return false;
        }

        return false;
    }

    public function setAttributes($attributes)
    {
        $attributes['personalDiscount'] = 0;
        return parent::setAttributes($attributes);
    }

    public function isB2C()
    {
        return $this->role === 'b2c';
    }

    public function isB2B()
    {
        return $this->role === 'b2b';
    }
}