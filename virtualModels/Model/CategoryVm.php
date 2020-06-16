<?php

namespace app\virtualModels\Model;

use app\virtualModels\Admin\Domains\Seo\SeoModelInterface;
use app\virtualModels\Admin\Domains\Seo\SeoModelTrait;
use app\virtualModels\Admin\Domains\Seo\SeoPageVm;
use app\virtualModels\Admin\Domains\Seo\SeoUrlObserver;
use app\virtualModels\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\Traits\ObserveVMTrait;

/**
 *
 * @property $id
 * @property $name
 * @property $photo
 * @property $slug
 *
 */
class CategoryVm extends VirtualModel implements SeoModelInterface
{
    use SeoModelTrait;

    use ObserveVMTrait;

    use MultilangTrait;

    public static function observers()
    {
        return [
            SeoUrlObserver::class,
        ];
    }

    public function attributes(): array
    {
        return [
            'id',
            'name',
            'photo',
            'slug',
        ];
    }

    public function buildUrl()
    {
        return '/'.$this->id.'-'.$this->slug;
    }

    public function getPhotoSafe()
    {
        return $this->attributes['photo'] ?: 'https://via.placeholder.com/300x300';
    }

    public function getProductsCount()
    {
        return ProductVm::count([
            'where' => [
                ['=', 'category_id', $this->id]
            ]
        ]);
    }
}