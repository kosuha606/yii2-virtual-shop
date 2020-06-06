<?php

namespace app\virtualModels\Domains\Page\Models;

use app\virtualModels\Admin\Domains\Search\SearchableInterface;
use app\virtualModels\Admin\Domains\Search\SearchIndexDto;
use app\virtualModels\Admin\Domains\Search\SearchObserver;
use app\virtualModels\Admin\Domains\Seo\SeoModelInterface;
use app\virtualModels\Admin\Domains\Seo\SeoModelTrait;
use app\virtualModels\Admin\Domains\Seo\SeoPageVm;
use app\virtualModels\Admin\Domains\Seo\SeoUrlObserver;
use app\virtualModels\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\Traits\ObserveVMTrait;
use yii\helpers\Url;

/**
 *
 * @property $id
 * @property $title
 * @property $slug
 * @property $content
 * @property $created_at
 *
 */
class PageVm extends VirtualModel
    implements
    SearchableInterface,
    SeoModelInterface
{
    use MultilangTrait;

    use ObserveVMTrait;

    use SeoModelTrait;

    public static function observers()
    {
        return [
            SearchObserver::class,
            SeoUrlObserver::class,
        ];
    }

    public function buildUrl()
    {
        return '/'.$this->id.'_'.$this->slug;
    }

    public function buildIndex(): SearchIndexDto
    {
        return new SearchIndexDto(
            1, [
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
            ]
        );
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