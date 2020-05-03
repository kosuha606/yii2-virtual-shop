<?php

namespace app\models;

use kosuha606\VirtualModel\VirtualModel;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 *
 */
class Favorite extends ActiveRecord
{
    public static function tableName()
    {
        return 'favorite';
    }

    public function rules()
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

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}