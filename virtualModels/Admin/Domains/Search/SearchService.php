<?php

namespace app\virtualModels\Admin\Domains\Search;

use kosuha606\VirtualModel\VirtualModelManager;

class SearchService
{
    /** @var SearchProviderInterface */
    private $searchProvider;

    /**
     * SearchService constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->searchProvider = VirtualModelManager::getInstance()->getProvider(SearchVm::KEY);

        if (!$this->searchProvider instanceof SearchProviderInterface) {
            throw new \Exception('Search provider should implement searchProviderInterface');
        }
    }

    public function indexInfo(): SearchIndexInfoDTO
    {
        return $this->searchProvider->indexInfo($this);
    }

    public function createIndex($model)
    {
        $this->searchProvider->createIndex($this, $model);
    }

    public function batchIndex($models)
    {
        $this->searchProvider->batchIndex($this, $models);
    }

    public function removeIndex($model)
    {
        $this->searchProvider->removeIndex($this, $model);
    }

    public function search($text)
    {
        $this->searchProvider->search($this, $text);
    }

    public function advancedSearch($config)
    {
        $this->searchProvider->advancedSearch($this, $config);
    }

    public function reindexAll()
    {
        return $this->searchProvider->reindexAll($this);
    }
}