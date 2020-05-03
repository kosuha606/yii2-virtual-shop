<?php

namespace app\virtualModels\Model;

use kosuha606\VirtualModel\VirtualModel;

/**
 * @property $id
 */
class FavoriteVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'user_id',
            'product_id',
            'product',
            'user',
        ];
    }
}