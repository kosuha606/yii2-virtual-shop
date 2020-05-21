<?php

namespace app\virtualModels\Domains\Menu\Models;

use kosuha606\VirtualModel\VirtualModel;

class MenuVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'name',
            'code',
        ];
    }

    /**
     * @return MenuItemVm[]
     * @throws \Exception
     */
    public function getItems()
    {
        $items = MenuItemVm::many(['where' => [['=', 'menu_id', $this->id]]]);

        return $items;
    }
}