<?php

namespace app\virtualModels\Admin\Domains\Search;

class SearchService
{
    public function createIndex($model)
    {
        return SearchVm::index($model);
    }

    public function batchIndex($models)
    {
        return SearchVm::batchIndex($models);
    }

    public function removeIndex($model)
    {
        return SearchVm::removeIndex($model);
    }

    public function search($text)
    {
        return SearchVm::search($text);
    }

    public function advancedSearch($config)
    {
        return SearchVm::advancedSearch($config);
    }
}