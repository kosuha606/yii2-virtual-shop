<?php

namespace app\virtualProviders;

use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModel\VirtualModelProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

class ActiveRecordProvider extends VirtualModelProvider
{
    public $relations;

    public function environemnt(): string
    {
        return 'ar';
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
        /** @var ActiveRecord $arClass */
        $arClass = $this->relations[$modelClass];
        $query = $arClass::find();

        $this->processQuery($query, $config);

        $model = $query->asArray()->one();

        return $model;
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
        /** @var ActiveRecord $arClass */
        $arClass = $this->relations[$modelClass];
        $query = $arClass::find();

        $this->processQuery($query, $config);

        $models = $query->asArray()->all();

        return $models;
    }

    /**
     * @param $query
     * @param $config
     */
    protected function processQuery(ActiveQuery $query, $config)
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
     * @throws \Exception
     */
    public function flush()
    {
        /** @var VirtualModel $model */
        foreach ($this->persistedModels as $model) {
            $modelClass = get_class($model);
            $this->ensureHaveRelation($modelClass);
            $arClass = $this->relations[$modelClass];
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
        /** @var ActiveRecord $arClass */
        $arClass = $this->relations[$modelClass];
        $ar = $arClass::findOne($model->id);
        $ar->delete();

        parent::delete($model);
    }

    private function ensureHaveRelation($modelClass)
    {
        if (!isset($this->relations[$modelClass])) {
            throw new \Exception("No such relation for class $modelClass in ActiveRecordProvider");
        }
    }
}
