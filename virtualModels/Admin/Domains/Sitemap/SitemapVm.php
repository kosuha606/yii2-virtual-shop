<?php

namespace app\virtualModels\Admin\Domains\Sitemap;

use kosuha606\VirtualModel\VirtualModel;

/**
 * @property SitemapItemDto[] $items
 * @method static getSitemapContent()
 */
class SitemapVm extends VirtualModel
{
    public static function providerType()
    {
        return SitemapProviderInterface::class;
    }

    public function attributes(): array
    {
        return [
            'items',
        ];
    }

    public function addItem(SitemapItemDto $dto)
    {
        if (!isset($this->attributes['items'])) {
            $this->attributes['items'] = [];
        }

        $this->attributes['items'][] = $dto;
    }
}