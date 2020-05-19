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
}