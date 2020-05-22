<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class DesignWidget extends ActiveRecord
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
        return 'design_widget';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'design_id',
                    'widget_id',
                    'position',
                    'order',
                    'config',
                ],
                'required'
            ]
        ];
    }
}