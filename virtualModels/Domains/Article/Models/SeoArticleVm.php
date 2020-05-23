<?php

namespace app\virtualModels\Domains\Article\Models;

use kosuha606\VirtualModel\VirtualModel;

class SeoArticleVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'article_id',
            'meta_title',
            'meta_keywords',
            'meta_description',
        ];
    }
}