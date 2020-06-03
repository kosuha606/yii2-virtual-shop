<?php

namespace app\virtualModels\Admin\Domains\Search;

interface SearchableInterface
{
    public function buildIndex(): SearchIndexDto;
}