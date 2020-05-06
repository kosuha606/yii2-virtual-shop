<?php

namespace app\virtualModels\Model;

use kosuha606\VirtualModel\VirtualModel;

class FilterProductVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'category_id',
            'product_id',
            'value',
        ];
    }
}