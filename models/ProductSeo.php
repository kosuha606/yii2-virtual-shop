<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $product_id [int(11)]
 * @property string $meta_title [varchar(255)]
 * @property string $meta_keywords [varchar(255)]
 * @property string $meta_description [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class ProductSeo extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'product_seo';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'product_id',
                ],
                'required'
            ],
            [
                [
                    'meta_title',
                    'meta_keywords',
                    'meta_description',
                ],
                'safe'
            ]
        ];
    }
}
