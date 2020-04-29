<?php

namespace app\virtualModels\Model;

use kosuha606\VirtualModel\VirtualModel;

/**
 * Акция для продукта
 * @package kosuha606\Model\iteration2\model
 */
class Action extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'productId',
            'percent',
            'userType',
        ];
    }
}