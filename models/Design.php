<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $route [varchar(255)]
 * @property int $priority [int(11)]
 * @property string $template
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Design extends BaseActiveRecord
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
        return 'design';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'name',
                    'route',
                    'priority',
                    'template',
                ],
                'required'
            ]
        ];
    }
}
