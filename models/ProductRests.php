<?php

namespace app\models;

use kosuha606\VirtualModel\VirtualModel;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Остаток по продукту
 * @package kosuha606\Model\iteration2\model
 * Остаток по продукту
 */
class ProductRests extends ActiveRecord
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
        return 'product_rests';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'productId',
                    'qty',
                    'userType',
                ],
                'required'
            ]
        ];
    }
}