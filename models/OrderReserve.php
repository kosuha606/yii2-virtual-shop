<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property int $orderId [int(11)]
 * @property int $productId [int(11)]
 * @property int $qty [int(11)]
 * @property string $userType [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class OrderReserve extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'order_reserve';
    }

    /**
     * @return array[]
     */
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
