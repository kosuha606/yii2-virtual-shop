<?php

namespace app\models;

use kosuha606\VirtualModel\VirtualModel;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Резерв продуктов в заказах
 * @package kosuha606\Model\iteration2\model
 */
class OrderReserve extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => new Expression('NOW()'),
            ],
        ];
    }

    public static function tableName()
    {
        return 'order_reserve';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'orderId',
                    'productId',
                    'qty',
                    'userType',
                ],
                'required',
            ],
        ];
    }
}