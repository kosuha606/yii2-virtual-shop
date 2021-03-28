<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $productId [int(11)]
 * @property int $qty [int(11)]
 * @property string $userType [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class ProductRests extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'product_rests';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'productId',
                    'qty',
                    'userType',
                ],
                'required'
            ]
        ];
    }
}
