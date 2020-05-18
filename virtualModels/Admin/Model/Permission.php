<?php

namespace app\virtualModels\Admin\Model;

use kosuha606\VirtualModel\VirtualModel;

class Permission extends VirtualModel
{
    const TYPE = 'permission';

    public static function providerType()
    {
        return self::TYPE;
    }

    public function attributes(): array
    {
        return [
            'id',
            'entity',
            'entity_id',
            'action',
            'user_id',
        ];
    }
}