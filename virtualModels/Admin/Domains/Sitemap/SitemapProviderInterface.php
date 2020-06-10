<?php

namespace app\virtualModels\Admin\Domains\Sitemap;

interface SitemapProviderInterface
{
    public function getSitemapContent();

    public function getBaseUrl();
}