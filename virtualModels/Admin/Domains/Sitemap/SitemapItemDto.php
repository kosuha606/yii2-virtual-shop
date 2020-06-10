<?php

namespace app\virtualModels\Admin\Domains\Sitemap;

class SitemapItemDto
{
    private $url;

    private $buildDate;

    private $freq = 'daily';

    private $importance = 0.3;

    public function __construct(
        $url,
        $buildDate,
        $freq = 'daily',
        $importance = 0.3
    ) {
        $this->url = $url;
        $this->buildDate = $buildDate;
        $this->freq = $freq;
        $this->importance = $importance;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getBuildDate()
    {
        return $this->buildDate;
    }

    /**
     * @return string
     */
    public function getFreq()
    {
        return $this->freq;
    }

    /**
     * @return float
     */
    public function getImportance()
    {
        return $this->importance;
    }
}