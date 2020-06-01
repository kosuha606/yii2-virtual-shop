<?php

namespace app\virtualModels\Admin\Test;

use app\virtualModels\Admin\Domains\Email\Email;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class TestEmailProvider extends MemoryModelProvider
{
    public function type()
    {
        return Email::KEY;
    }

    public function send($ids)
    {
        // send ids
    }
}