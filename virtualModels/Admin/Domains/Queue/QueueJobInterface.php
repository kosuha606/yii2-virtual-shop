<?php

namespace app\virtualModels\Admin\Domains\Queue;

interface QueueJobInterface
{
    public function run($arguments = []);
}