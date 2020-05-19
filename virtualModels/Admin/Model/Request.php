<?php

namespace app\virtualModels\Admin\Model;

use kosuha606\VirtualModel\VirtualModel;

/**
 * @property $get
 * @property $post
 * @property $isAjax
 * @property $isPost
 */
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
            'isPost',
        ];
    }
}