<?php

namespace app\virtualModels\Domains\Menu\Models;

use app\virtualModels\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModel;

class MenuItemVm extends VirtualModel
{
    use MultilangTrait;

    public function attributes(): array
    {
        return [
            'id',
            'link',
            'label',
            'menu_id',
            'order',
        ];
    }
}