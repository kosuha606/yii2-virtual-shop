<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property int $user_id [int(11)]
 * @property int $model_id [int(11)]
 * @property string $model_class [varchar(255)]
 * @property string $content [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Comment extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'comment';
    }

    /**
     * @return array[]
     */
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
