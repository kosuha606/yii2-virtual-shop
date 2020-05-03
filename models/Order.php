<?php

namespace app\models;

use kosuha606\VirtualModel\VirtualModel;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public static function tableName()
    {
        return 'order';
    }

    public function rules()
    {
        return [
            [
                [
                    'orderData',
                    'total',
                    'userType',
                ],
                'required',
            ],
            [
                'user_id',
                'safe'
            ]
        ];
    }
}