<?php

namespace app\virtual\Domains\Framework;

interface FrameworkProviderInterface
{
    public function login($modelClass, $data);

    public function registerJs($modelClass, $jsCode);
}