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

    /**
     * @return mixed
     */
    public function getIndexId()
    {
        return $this->indexId;
    }

    /**
     * @param mixed $indexId
     * @return SearchIndexDto
     */
    public function setIndexId($indexId)
    {
        $this->indexId = $indexId;

        return $this;
    }

    /**
     * @return array
     */
    public function getIndexData(): array
    {
        return $this->indexData;
    }

    /**
     * @param array $indexData
     * @return SearchIndexDto
     */
    public function setIndexData(array $indexData): SearchIndexDto
    {
        $this->indexData = $indexData;

        return $this;
    }
}