<?php

namespace app\virtualModels\Domains\Cache;

use kosuha606\VirtualModel\VirtualModel;

/**
 *
 * @property $entity_id
 * @property $entity_class
 * @property $data
 *
 */
class CacheVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'entity_id',
            'entity_class',
            'data',
        ];
    }
}