<?php

namespace app\virtualProviders;

use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModel\VirtualModelProvider;
use LogicException;
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
        $ids = [];
        /** @var VirtualModel $model */
        foreach ($this->persistedModels as $model) {
            $modelClass = get_class($model);
            $this->ensureHaveRelation($modelClass);
            $arConfig = $this->relations[$modelClass];
            $arClass = $arConfig['ar'];
            /** @var ActiveRecord $ar */
            $ar = new $arClass();
            $ar->setAttributes($model->getAttributes());
            if ($model->hasAttribute('id') && $model->id) {
                $ar->setIsNewRecord(false);
                $ar->setOldAttributes(['id' => $model->id]);
                $ar->id = $model->id;
            }
            if (!$ar->validate()) {
                $message = $ar->getErrorSummary(true);
                throw new LogicException(implode(',', $message));
            }
            $result = $ar->save();
            $ids[] = $ar->id;
        }

        parent::flush();

        return $ids;
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
                    case 'in':
                    case 'like':
                    case '>':
                    case '<':
                    case '>=':
                    case '<=':
                        $query->andWhere([$whereConfig[0], $whereConfig[1], $whereConfig[2]]);
                        break;
                }
            }
        }

        if (isset($config['select'])) {
            $query->select($config['select']);
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

    public function count($modelClass, $config)
    {
        $this->ensureHaveRelation($modelClass);
        $arConfig = $this->relations[$modelClass];
        /** @var ActiveRecord $arClass */
        $arClass = $arConfig['ar'];
        $query = $arClass::find();

        $this->processQuery($query, $config, $arConfig);

        return $query->count();
    }
}
