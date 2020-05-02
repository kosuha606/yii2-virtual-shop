<?php

namespace app\virtualModels\Model;

use kosuha606\VirtualModel\VirtualModel;

/**
 * Остаток по продукту
 * @package kosuha606\Model\iteration2\model
 * Остаток по продукту
 * @property $qty
 */
class ProductRestsVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'productId',
            'qty',
            'userType',
        ];
    }
}