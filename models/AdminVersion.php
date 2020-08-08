<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Inflector;

class AdminVersion extends ActiveRecord
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
        return 'admin_version';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'entity_id',
                    'user_id',
                    'entity_class',
                    'form_data',
                    'form_config',
                ],
                'required'
            ]
        ];
    }
}