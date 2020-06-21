<?php

namespace app\virtualProviders\ZendLuceneSearch;

use kosuha606\VirtualAdmin\Domains\Search\SearchableInterface;
use kosuha606\VirtualAdmin\Domains\Search\SearchIndexInfoDTO;
use kosuha606\VirtualAdmin\Domains\Search\SearchProviderInterface;
use kosuha606\VirtualAdmin\Domains\Search\SearchService;
use kosuha606\VirtualAdmin\Domains\Search\SearchVm;
use kosuha606\VirtualModel\Example\MemoryModelProvider;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\ServiceManager;
use kosuha606\VirtualShop\Model\ProductVm;
use kosuha606\VirtualContent\Domains\Article\Models\ArticleVm;
use kosuha606\VirtualContent\Domains\Page\Models\PageVm;

class ZendLuceneSearchProvider extends MemoryModelProvider implements SearchProviderInterface
{
    public $zendService;

    private $indexModels = [
        PageVm::class,
        ArticleVm::class,
        ProductVm::class,
    ];

    public function type()
    {
        return SearchVm::KEY;
    }

    /**
     * @param $caller
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public function reindexAll($caller)
    {
        $searchService = ServiceManager::getInstance()->get(SearchService::class);

        /** @var VirtualModel $modelClass */
        foreach ($this->indexModels as $modelClass) {
            /** @var SearchableInterface[] $models */
            $models = $modelClass::many(['where' => [['all']]]);

            foreach ($models as $model) {
                $searchService->removeIndex($model);
                $searchService->createIndex($model);
            }
        }
    }

    public function __construct()
    {
        $this->zendService = new ZendSearchService();
    }

    /**
     * @param $caller
     * @return SearchIndexInfoDTO
     * @throws \yii\base\InvalidConfigException
     */
    public function indexInfo($caller): SearchIndexInfoDTO
    {
        $index = $this->zendService->getIndex();

        return new SearchIndexInfoDTO(
            $index->numDocs()
        );
    }

    /**
     * @param $caller
     * @param SearchableInterface $model
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function createIndex($caller, SearchableInterface $model)
    {
        $this->index($caller, $model);
    }

    /**
     * @param $caller
     * @param SearchableInterface $model
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function index($caller, SearchableInterface $model)
    {
        $indexDto = $model->buildIndex();
        $indexDtoData = $indexDto->getIndexData();
        $indexDtoData[] = [
            'field' => 'model_id',
            'value' => $model->id,
            'type' => 'keyword',
        ];
        $indexDtoData[] = [
            'field' => 'model_class',
            'value' => get_class($model),
            'type' => 'keyword',
        ];
        $this->zendService->indexArray($indexDtoData);
    }

    /**
     * @param $caller
     * @param SearchableInterface[] $models
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function batchIndex($caller, $models)
    {
        foreach ($models as $model) {
            $this->index($caller, $model);
        }
    }

    public function removeIndex($caller,SearchableInterface $model)
    {
        $modelId = $model->id;
        $modelClass = get_class($model);
        $this->zendService->removeFromIndex($modelId, $modelClass);
    }

    public function search($caller, $text)
    {
        return $this->zendService->search($text);
    }

    public function advancedSearch($caller, $config)
    {
        // nothing
    }
}