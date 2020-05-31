<?php

namespace app\virtualModels\Admin\Domains\Queue;

use kosuha606\VirtualModel\VirtualModel;

/**
 *
 * @property $job_class
 * @property $arguments
 * @property $created_at
 *
 */
class QueueVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'job_class',
            'arguments',
            'created_at',
        ];
    }
}