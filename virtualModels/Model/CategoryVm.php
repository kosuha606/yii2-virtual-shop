<?php

namespace app\virtualModels\Model;

use app\virtualModels\Admin\Domains\Seo\SeoModelInterface;
use app\virtualModels\Admin\Domains\Seo\SeoModelTrait;
use app\virtualModels\Admin\Domains\Seo\SeoPageVm;
use kosuha606\VirtualModel\VirtualModel;

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
        return '/'.$this->id.'_'.$this->slug;
    }

    public function getPhotoSafe()
    {
        return $this->attributes['photo'] ?: 'https://via.placeholder.com/300x300';
    }
}