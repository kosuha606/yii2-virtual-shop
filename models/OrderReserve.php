<?php

namespace app\models;

use kosuha606\VirtualModel\VirtualModel;
use yii\db\ActiveRecord;

/**
 * Резерв продуктов в заказах
 * @package kosuha606\Model\iteration2\model
 */
class OrderReserve extends ActiveRecord
{
    public static function tableName()
    {
        return 'order_reserve';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'orderId',
                    'productId',
                    'qty',
                    'userType',
                ],
                'required',
            ],
        ];
    }
}