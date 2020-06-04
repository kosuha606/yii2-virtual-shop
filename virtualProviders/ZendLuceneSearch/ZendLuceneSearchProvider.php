<?php

namespace app\virtualProviders\ZendLuceneSearch;

use app\virtualModels\Admin\Domains\Search\SearchableInterface;
use app\virtualModels\Admin\Domains\Search\SearchVm;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class ZendLuceneSearchProvider extends MemoryModelProvider
{
    public $zendService;

    public function type()
    {
        return SearchVm::KEY;
    }

    public function __construct()
    {
        $this->zendService = new ZendSearchService();
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