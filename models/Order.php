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
                    'user_id',
                    'orderData',
                    'total',
                    'userType',
                ],
                'required',
            ],
        ];
    }
}