<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property int $id [int(11)]
 * @property string $description [varchar(255)]
 * @property string $code [varchar(255)]
 * @property string $content
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Text extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'text';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'description',
                    'code',
                    'content',
                ],
                'required'
            ]
        ];
    }
}
