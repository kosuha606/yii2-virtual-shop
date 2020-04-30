<?php

namespace app\virtualModels\Model;

use kosuha606\VirtualModel\VirtualModel;

/**
 * Акция для продукта
 * @package kosuha606\Model\iteration2\model
 */
class ActionVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'productIds',
            'percent',
            'userType',
        ];
    }

    public function getProductIds()
    {
        if (is_array($this->attributes['productIds'])) {
            $result = $this->attributes['productIds'];
        } else {
            $result = json_decode($this->attributes['productIds'], JSON_UNESCAPED_UNICODE);
        }

        return $result;
    }
}