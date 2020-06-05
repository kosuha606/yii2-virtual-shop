<?php

namespace app\virtualModels\Admin\Domains\Search;

class SearchIndexInfoDTO
{
    private $numbDocs;

    public function __construct($numbDocs)
    {
        $this->numbDocs = $numbDocs;
    }

    /**
     * @return mixed
     */
    public function getNumbDocs()
    {
        return $this->numbDocs;
    }

    /**
     * @param mixed $numbDocs
     * @return SearchIndexInfoDTO
     */
    public function setNumbDocs($numbDocs)
    {
        $this->numbDocs = $numbDocs;

        return $this;
    }
}