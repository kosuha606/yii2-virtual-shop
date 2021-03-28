<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property string $code [varchar(255)]
 * @property string $name [varchar(255)]
 * @property bool $is_default [tinyint(1)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Lang extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'lang';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'code',
                    'name',
                    'is_default',
                ],
                'required'
            ]
        ];
    }
}
