<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class FilterCategory extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'filter_category';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                'name',
            ],
            'required',
        ];
    }
}
