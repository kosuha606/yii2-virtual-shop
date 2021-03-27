<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Order extends ActiveRecord
{
    /**
     * @return array[]
     */
    public function behaviors(): array
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

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'order';
    }

    /**
     * @return array
     */
    public function rules(): array
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
