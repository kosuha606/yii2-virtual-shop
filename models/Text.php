<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property string $description [varchar(255)]
 * @property string $code [varchar(255)]
 * @property string $content
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Text extends BaseActiveRecord
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
