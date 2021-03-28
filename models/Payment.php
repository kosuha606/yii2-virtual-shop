<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property int $comission [int(11)]
 * @property string $description [varchar(255)]
 * @property string $userType [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Payment extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'payment';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'comission',
                    'description',
                    'userType',
                ],
                'required',
            ]
        ];
    }
}
