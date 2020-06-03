<?php

namespace app\virtualModels\Admin\Domains\Search;

use kosuha606\VirtualModelHelppack\ServiceManager;

class SearchObserver
{
    /**
     * @param SearchableInterface $model
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function afterSave(SearchableInterface $model)
    {
        $searchService = ServiceManager::getInstance()->get(SearchService::class);
        $searchService->removeIndex($model);
        $searchService->createIndex($model);

    }

    /**
     * @param SearchableInterface $model
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function afterDelete(SearchableInterface $model)
    {
        $searchService = ServiceManager::getInstance()->get(SearchService::class);
        $searchService->removeIndex($model);
    }
}