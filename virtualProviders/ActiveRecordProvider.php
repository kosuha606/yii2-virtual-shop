<?php

namespace app\virtualProviders;

use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModel\VirtualModelProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ActiveRecordProvider extends VirtualModelProvider
{
    public $relations;

    public function environemnt(): string
    {
        return 'ar';
    }

    /**
     * @throws \Exception
     */
    public function flush()
    {
        /** @var VirtualModel $model */
        foreach ($this->persistedModels as $model) {
            $modelClass = get_class($model);
            $this->ensureHaveRelation($modelClass);
            $arConfig = $this->relations[$modelClass];
            $arClass = $arConfig['ar'];
            /** @var ActiveRecord $ar */
            $ar = new $arClass();
            $ar->setAttributes($model->getAttributes());
            $ar->save();
        }

        parent::flush();
    }

    /**
     * @param VirtualModel $model
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete(VirtualModel $model)
    {
        $modelClass = get_class($model);
        $this->ensureHaveRelation($modelClass);
        $arConfig = $this->relations[$modelClass];
        /** @var ActiveRecord $arClass */
        $arClass = $arConfig['ar'];
        $ar = $arClass::findOne($model->id);
        $ar->delete();

        parent::delete($model);
    }

    /**
     * @param $modelClass
     * @param $config
     * @return mixed|void
     * @throws \Exception
     */
    protected function findOne($modelClass, $config)
    {
        $this->ensureHaveRelation($modelClass);
        $arConfig = $this->relations[$modelClass];
        /** @var ActiveRecord $arClass */
        $arClass = $arConfig['ar'];
        $query = $arClass::find();

        $this->processQuery($query, $config, $arConfig);

        $model = $query->asArray()->one();

        return $model;
    }

    private function ensureHaveRelation($modelClass)
    {
        if (!isset($this->relations[$modelClass])) {
            throw new \Exception("No such relation for class $modelClass in ActiveRecordProvider");
        }
    }

    /**
     * @param $query
     * @param $config
     */
    protected function processQuery(ActiveQuery $query, $config, $arConfig)
    {
        if (isset($config['where'])) {
            foreach ($config['where'] as $whereConfig) {
                switch ($whereConfig[0]) {
                    case '=':
                        $query->andWhere([$whereConfig[1] => $whereConfig[2]]);
                        break;
                }
            }
        }

        if (isset($arConfig['with'])) {
            foreach ($arConfig['with'] as $with) {
                $query->with($with);
            }
        }

        if (isset($config['orderBy'])) {
            $query->orderBy($config['orderBy']);
        }

        if (isset($config['groupBy'])) {
            $query->groupBy($config['groupBy']);
        }

        if (isset($config['limit'])) {
            $query->limit($config['limit']);
        }

        if (isset($config['offset'])) {
            $query->offset($config['offset']);
        }
    }

    /**
     * @param $modelClass
     * @param $config
     * @return mixed|void
     * @throws \Exception
     */
    protected function findMany($modelClass, $config)
    {
        $this->ensureHaveRelation($modelClass);
        $arConfig = $this->relations[$modelClass];
        /** @var ActiveRecord $arClass */
        $arClass = $arConfig['ar'];
        $query = $arClass::find();

        $this->processQuery($query, $config, $arConfig);

        $models = $query->asArray()->all();

        return $models;
    }
}
