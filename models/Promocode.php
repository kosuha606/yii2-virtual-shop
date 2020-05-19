<?php

namespace app\models;

use kosuha606\VirtualModel\VirtualModel;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Промокод для корзины
 * @package kosuha606\Model\iteration2\model
 */
class Promocode extends ActiveRecord
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
        return 'promocode';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'amount',
                    'code',
                ],
                'required'
            ],
            [
                [
                    'userType',
                ],
                'safe'
            ]
        ];
    }
}