<?php

namespace app\models;

use kosuha606\VirtualModel\VirtualModel;
use yii\db\ActiveRecord;

/**
 * Остаток по продукту
 * @package kosuha606\Model\iteration2\model
 * Остаток по продукту
 */
class ProductRests extends ActiveRecord
{
    public static function tableName()
    {
        return 'product_rests';
    }

    public function rules(): array
    {
        return [
            [
                'productId',
                'qty',
                'userType',
            ],
            'required'
        ];
    }
}