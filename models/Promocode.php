<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Promocode extends ActiveRecord
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
        return 'promocode';
    }

    /**
     * @return array[]
     */
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
