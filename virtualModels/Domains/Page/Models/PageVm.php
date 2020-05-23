<?php

namespace app\virtualModels\Domains\Page\Models;

use kosuha606\VirtualModel\VirtualModel;

class PageVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'title',
            'slug',
            'content',
            'created_at',
        ];
    }
}