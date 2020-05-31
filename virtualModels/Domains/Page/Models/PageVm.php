<?php

namespace app\virtualModels\Domains\Page\Models;

use app\virtualModels\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModel;

class PageVm extends VirtualModel
{
    use MultilangTrait;

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