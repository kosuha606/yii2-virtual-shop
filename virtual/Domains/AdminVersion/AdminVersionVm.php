<?php

namespace app\virtual\Domains\AdminVersion;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $id
 * @property $entity_id
 * @property $user_id
 * @property $entity_class
 * @property $form_data
 * @property $form_config
 * @property $created_at
 *
 */
class AdminVersionVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'user_id',
            'entity_id',
            'entity_class',
            'form_data',
            'form_config',
            'created_at',
        ];
    }
}