<?php

namespace app\models;



use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModel\Example\Shop\ServiceManager;
use kosuha606\VirtualModel\Example\Shop\Services\ProductService;
use yii\db\ActiveRecord;

/**
 * Продукт
 */
class Product extends ActiveRecord
{
    public static function tableName()
    {
        return 'product';
    }

    public function rules(): array
    {
        return [
            [
                'name',
                'price',
                'price2B',
                'actions',
                'rests',
            ],
            'required',
        ];
    }
}