<?php

namespace app\virtualModels\Admin\Test;

use kosuha606\VirtualModel\Example\MemoryModelProvider;

class TestSystemAlertProvider extends MemoryModelProvider
{
    public function type()
    {
        return 'system_alert';
    }
}