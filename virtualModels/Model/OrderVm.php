<?php

namespace app\virtualModels\Model;

use kosuha606\VirtualModel\VirtualModel;

class OrderVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'items',
            'userType',
            'reserve',
        ];
    }
}