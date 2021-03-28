<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $code [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Menu extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'menu';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'name',
                    'code',
                ],
                'required'
            ]
        ];
    }
}
