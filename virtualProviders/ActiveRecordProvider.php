<?php

namespace app\virtualProviders;

use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModel\VirtualModelProvider;
use LogicException;
use yii\base\Event;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ActiveRecordProvider extends VirtualModelProvider
{
    public array $relations;

    /**
     * @return string
     */
    public function environemnt(): string
    {
        return 'ar';
    }

    /**
     * @return array
     */
    public function flush(): array
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

            $ar->save();
            $ids[] = $ar->id;
        }

        parent::flush();

        return $ids;
    }

    /**
     * @param VirtualModel $model
     */
    public function delete(VirtualModelEntity $model): void
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
     * @param string $modelClass
     * @param array $config
     * @return array|mixed|ActiveRecord|null
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

        Event::trigger($modelClass, 'afterFindOne');

        return $model;
    }

    /**
     * @param $modelClass
     */
    private function ensureHaveRelation($modelClass): void
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

        Event::trigger($modelClass, 'afterFindMany');

        return $models;
    }

    /**
     * @param $modelClass
     * @param $config
     * @return int|string
     * @throws \Exception
     */
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

    /**
     * @param $modelClass
     * @param $config
     */
    public function deleteByCondition($modelClass, $config)
    {
        $this->ensureHaveRelation($modelClass);
        $arConfig = $this->relations[$modelClass];
        /** @var ActiveRecord $arClass */
        $arClass = $arConfig['ar'];
        $arClass::deleteAll($config['where']);
    }

    /**
     * @return array
     */
    public function getAvailableModelClasses()
    {
        return array_keys($this->relations);
    }
}
