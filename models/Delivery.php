<?php

namespace app\models;

use kosuha606\VirtualModel\VirtualModel;
use yii\db\ActiveRecord;

/**
 * Вариант доставки
 * @package kosuha606\Model\iteration2\model
 */
class Delivery extends ActiveRecord
{
    public static function tableName()
    {
        return 'delivery';
    }

    public function rules()
    {
        return [
            [
                'price',
                'description',
                'userType',
            ],
            'required',
        ];
    }
}