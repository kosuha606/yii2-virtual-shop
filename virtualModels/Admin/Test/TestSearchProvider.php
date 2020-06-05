<?php

namespace app\virtualModels\Admin\Test;

use app\virtualModels\Admin\Domains\Search\SearchableInterface;
use app\virtualModels\Admin\Domains\Search\SearchIndexInfoDTO;
use app\virtualModels\Admin\Domains\Search\SearchProviderInterface;
use app\virtualModels\Admin\Domains\Search\SearchVm;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class TestSearchProvider extends MemoryModelProvider implements SearchProviderInterface
{
    public function type()
    {
        return SearchVm::KEY;
    }

    public function createIndex($caller, SearchableInterface $model)
    {
        // TODO: Implement createIndex() method.
    }

    public function indexInfo($caller): SearchIndexInfoDTO
    {
        // TODO: Implement indexInfo() method.
    }

    public function index($caller, SearchableInterface $model)
    {
        // nothing
    }

    public function batchIndex($caller, $models)
    {
        // nothing
    }

    public function removeIndex($caller,SearchableInterface $model)
    {
        // nothing
    }

    public function search($caller, $text)
    {
        // nothing
    }

    public function advancedSearch($caller, $config)
    {
        // nothing
    }

    public function reindexAll($caller)
    {
        // TODO: Implement reindexAll() method.
    }

}