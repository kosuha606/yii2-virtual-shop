<?php

namespace app\virtualModels\Model;

use kosuha606\VirtualModel\VirtualModel;

/**
 * Вариант оплаты
 * @package kosuha606\Model\iteration2\model
 */
class Payment extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'comission',
            'description',
            'userType',
        ];
    }
}