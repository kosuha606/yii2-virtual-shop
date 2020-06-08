<?php

namespace app\virtualModels\Admin\Domains\Settings;

use kosuha606\VirtualModel\VirtualModel;

class SettingsVm extends VirtualModel
{
    const KEY = SettingsProviderInterface::class;

    public function attributes(): array
    {
        return [
            'id',
            'config'
        ];
    }
}