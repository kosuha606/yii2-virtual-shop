<?php

namespace app\virtualModels\Domains\Article\Models;

use app\virtualModels\Admin\Domains\Version\VersionObserver;
use app\virtualModels\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\Traits\ObserveVMTrait;

class ArticleVm extends VirtualModel
{
    use MultilangTrait;

    use ObserveVMTrait;

    public static function observers()
    {
        return [
            VersionObserver::class
        ];
    }

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