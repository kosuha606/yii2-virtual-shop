<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * @property-read \yii\db\ActiveQuery $product
 * @property-read \yii\db\ActiveQuery $user
 * @property int $id [int(11)]
 * @property int $user_id [int(11)]
 * @property int $product_id [int(11)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Favorite extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'favorite';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'user_id',
                    'product_id',
                ],
                'required',
            ]
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
