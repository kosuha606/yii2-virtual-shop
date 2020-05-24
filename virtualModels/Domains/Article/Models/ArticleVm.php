<?php

namespace app\virtualModels\Domains\Article\Models;

use kosuha606\VirtualModel\VirtualModel;

class ArticleVm extends VirtualModel
{
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