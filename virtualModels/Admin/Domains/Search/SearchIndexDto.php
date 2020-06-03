<?php

namespace app\virtualModels\Admin\Domains\Search;

class SearchIndexDto
{
    private $indexId;

    /**
     * @var array
     */
    private $indexData;

    public function __construct($indexId, $indexData = [])
    {
        $this->indexId = $indexId;
        $this->indexData = $indexData;
    }
}