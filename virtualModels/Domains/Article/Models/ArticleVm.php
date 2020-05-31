<?php

namespace app\virtualModels\Domains\Article\Models;

use app\virtualModels\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModel;

class ArticleVm extends VirtualModel
{
    use MultilangTrait;

    public function attributes(): array
    {
        return [
            'id',
            'title',
            'photo',
            'slug',
            'content',
            'created_at',
        ];
    }
}