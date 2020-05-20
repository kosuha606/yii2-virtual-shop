<?php

namespace app\virtualModels\Admin\Test;

use app\virtualModels\Admin\Model\Request;
use app\virtualModels\Admin\Model\Session;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class TestRequestProvider extends MemoryModelProvider
{
    public function type()
    {
        return Request::TYPE;
    }

    public function findMany($modelClass, $config)
    {
        $data = parent::findMany($modelClass, $config);
        return $data;
    }

    public function findOne($modelClass, $config)
    {
        $data = parent::findOne($modelClass, $config);
        return $data;
    }
}