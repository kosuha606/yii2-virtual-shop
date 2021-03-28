<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property int $amount [int(11)]
 * @property string $code [varchar(255)]
 * @property string $userType [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Promocode extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'promocode';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'amount',
                    'code',
                ],
                'required'
            ],
            [
                [
                    'userType',
                ],
                'safe'
            ]
        ];
    }
}
