<?php

namespace app\virtualModels\Admin\Domains\Search;

interface SearchProviderInterface
{
    public function indexInfo($caller): SearchIndexInfoDTO;

    public function createIndex($caller,SearchableInterface $model);

    public function batchIndex($caller, $models);

    public function removeIndex($caller,SearchableInterface $model);

    public function search($caller, $text);

    public function advancedSearch($caller, $config);

    public function reindexAll($caller);
}