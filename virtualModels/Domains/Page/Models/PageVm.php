<?php

namespace app\virtualModels\Domains\Page\Models;

use app\virtualModels\Admin\Domains\Search\SearchableInterface;
use app\virtualModels\Admin\Domains\Search\SearchIndexDto;
use app\virtualModels\Admin\Domains\Search\SearchObserver;
use app\virtualModels\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\Traits\ObserveVMTrait;
use yii\helpers\Url;

class PageVm extends VirtualModel implements SearchableInterface
{
    use MultilangTrait;

    use ObserveVMTrait;

    public static function observers()
    {
        return [
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
                'field' => 'url',
                'value' => Url::toRoute(['page/detail', 'id' => $this->id, 'slug' => $this->slug]),
                'type' => 'keyword',
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
            'slug',
            'content',
            'created_at',
        ];
    }
}