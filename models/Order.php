<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property string $orderData
 * @property string $total [varchar(255)]
 * @property int $user_id [int(11)]
 * @property string $userType [varchar(255)]
 * @property string $reserve
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Order extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'order';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'orderData',
                    'total',
                    'userType',
                ],
                'required',
            ],
            [
                'user_id',
                'safe'
            ]
        ];
    }
}
