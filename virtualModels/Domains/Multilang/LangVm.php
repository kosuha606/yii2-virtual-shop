<?php

namespace app\virtualModels\Domains\Multilang;

use kosuha606\VirtualModel\VirtualModel;

class LangVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'code',
            'name',
        ];
    }
}