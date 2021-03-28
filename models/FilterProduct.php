<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property int $category_id [int(11)]
 * @property int $product_id [int(11)]
 * @property string $value [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class FilterProduct extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'filter_product';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'category_id',
                    'product_id',
                    'value',
                ],
                'required',
            ]
        ];
    }
}
