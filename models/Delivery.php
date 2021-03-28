<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property int $price [int(11)]
 * @property string $description [varchar(255)]
 * @property string $userType [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Delivery extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'delivery';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'price',
                    'description',
                    'userType',
                ],
                'required',
            ]
        ];
    }
}
