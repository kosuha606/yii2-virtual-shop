<?php

namespace app\models;

use kosuha606\VirtualModel\VirtualModel;
use yii\db\ActiveRecord;

/**
 * Промокод для корзины
 * @package kosuha606\Model\iteration2\model
 */
class Promocode extends ActiveRecord
{
    public static function tableName()
    {
        return 'promocode';
    }

    public function rules(): array
    {
        return [
            [
                'amount',
                'code',
                'userType',
            ],
            'required'
        ];
    }
}