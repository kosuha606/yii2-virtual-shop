<?php

namespace app\virtualModels\Admin\Model;

use kosuha606\VirtualModel\VirtualModel;

class Request extends VirtualModel
{
    const TYPE = 'request';

    public static function providerType()
    {
        return self::TYPE;
    }

    public function attributes(): array
    {
        return [
            'get',
            'post',
            'isAjax',
        ];
    }
}