<?php

namespace app\virtualModels\Admin\Test;

use app\virtualModels\Admin\Domains\Search\SearchableInterface;
use app\virtualModels\Admin\Domains\Search\SearchVm;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class TestSearchProvider extends MemoryModelProvider
{
    public function type()
    {
        return SearchVm::KEY;
    }

    public function index($caller, SearchableInterface $model)
    {
        // nothing
    }

    public function batchIndex($caller, SearchableInterface $model)
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
}