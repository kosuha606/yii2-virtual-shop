<?php

namespace app\virtualModels\Domains\Article\Models;

use app\virtualModels\Admin\Domains\Search\SearchableInterface;
use app\virtualModels\Admin\Domains\Search\SearchIndexDto;
use app\virtualModels\Admin\Domains\Search\SearchObserver;
use app\virtualModels\Admin\Domains\Version\VersionObserver;
use app\virtualModels\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\Traits\ObserveVMTrait;

/**
 *
 * @property  $id
 * @property  $title
 * @property  $photo
 * @property  $slug
 * @property  $content
 * @property  $created_at
 *
 */
class ArticleVm extends VirtualModel implements SearchableInterface
{
    use MultilangTrait;

    use ObserveVMTrait;

    public static function observers()
    {
        return [
            VersionObserver::class,
            SearchObserver::class,
        ];
    }

    public function buildIndex(): SearchIndexDto
    {
        return new SearchIndexDto(1, [
            [
                'field' => 'title',
                'value' => $this->title,
                'type' => 'text',
            ],
            [
                'field' => 'content',
                'value' => $this->content,
                'type' => 'text',
            ],
        ]);
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