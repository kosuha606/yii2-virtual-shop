<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Inflector;

class Comment extends ActiveRecord
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
        return 'comment';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'user_id',
                    'model_id',
                    'model_class',
                    'content',
                ],
                'required'
            ]
        ];
    }
}