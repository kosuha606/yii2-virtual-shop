<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property int $entity_id [int(11)]
 * @property string $entity_class [varchar(255)]
 * @property string $data
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Cache extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'cache';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'entity_id',
                    'entity_class',
                    'data',
                ],
                'required'
            ]
        ];
    }
}
