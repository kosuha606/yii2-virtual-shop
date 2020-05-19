<?php

namespace app\virtualModels\Admin\Test;

use app\virtualModels\Admin\Model\Session;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class TestSessionProvider extends MemoryModelProvider
{
    public function type()
    {
        return Session::TYPE;
    }
}