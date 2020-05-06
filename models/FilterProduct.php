<?php

namespace app\models;

use yii\db\ActiveRecord;

class FilterProduct extends ActiveRecord
{
    public static function tableName()
    {
        return 'filter_product';
    }

    public function rules()
    {
        return [
            [
                'category_id',
                'product_id',
                'value',
            ],
            'required',
        ];
    }
}