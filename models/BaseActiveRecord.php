<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

abstract class BaseActiveRecord extends ActiveRecord
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
     * @param array $row
     * @return BaseActiveRecord|object|static
     */
    public static function instantiate($row)
    {
        return Yii::createObject(static::class);
    }
}
