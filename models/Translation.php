<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Translation extends ActiveRecord
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
        return 'translation';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'entity_id',
                    'entity_class',
                    'lang_id',
                    'attribute',
                    'data',
                ],
                'required'
            ]
        ];
    }
}