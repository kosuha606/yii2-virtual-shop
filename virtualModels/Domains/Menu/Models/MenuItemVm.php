<?php

namespace app\virtualModels\Domains\Menu\Models;

use kosuha606\VirtualModel\VirtualModel;

class MenuItemVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'link',
            'label',
            'menu_id',
        ];
    }
}