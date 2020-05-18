<?php

namespace app\virtualModels\Admin\Model;

use kosuha606\VirtualModel\VirtualModel;

/**
 * @property $type
 * @property $message
 */
class Alert extends VirtualModel
{
    public static function providerType()
    {
        return 'system_alert';
    }

    public function attributes(): array
    {
        return [
            'type',
            'message',
        ];
    }
}