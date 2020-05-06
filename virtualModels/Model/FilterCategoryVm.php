<?php

namespace app\virtualModels\Model;

use kosuha606\VirtualModel\VirtualModel;

class FilterCategoryVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'name',
        ];
    }
}