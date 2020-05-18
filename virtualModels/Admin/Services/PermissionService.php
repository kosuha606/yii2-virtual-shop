<?php

namespace app\virtualModels\Admin\Services;

use app\virtualModels\Admin\Model\Permission;
use app\virtualModels\Model\UserVm;
use kosuha606\VirtualModel\VirtualModel;

class PermissionService
{
    /**
     * Проверка доступности действия пользователю
     *
     * @param $action
     * @param $user
     * @throws \Exception
     */
    public function ensureActionAvailable($action, UserVm $user)
    {
        /** @var Permission $permission */
        $permission = Permission::one(['where' => [
            ['=', 'action', $action],
            ['=', 'user_id', $user->id]
        ]]);

        if ($permission->action !== $action) {
            Permission::throw403();
        }
    }

    /**
     * Проверка доступности типа сущности пользователю
     *
     * @param $entity
     * @param $user
     * @throws \Exception
     */
    public function ensureEntityTypeAvailable($entityType, UserVm $user)
    {
        /** @var Permission $permission */
        $permission = Permission::one(['where' => [
            ['=', 'entity', $entityType],
            ['=', 'user_id', $user->id]
        ]]);

        if ($permission->entity !== $entityType) {
            Permission::throw403();
        }
    }

    /**
     * Проверка доступности сущности пользователю
     *
     * @param $entity
     * @param $user
     * @throws \Exception
     */
    public function ensureEntityAvailable(VirtualModel $entity, UserVm $user)
    {
        /** @var Permission $permission */
        $permission = Permission::one(['where' => [
            ['=', 'entity', get_class($entity)],
            ['=', 'entity_id', $entity->id],
            ['=', 'user_id', $user->id]
        ]]);

        if ($permission->entity !== get_class($entity)) {
            Permission::throw403();
        }
    }
}