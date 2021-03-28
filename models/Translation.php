<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property int $entity_id [int(11)]
 * @property string $entity_class [varchar(255)]
 * @property int $lang_id [int(11)]
 * @property string $attribute [varchar(255)]
 * @property string $data
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Translation extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'translation';
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
                    'lang_id',
                    'attribute',
                    'data',
                ],
                'required'
            ]
        ];
    }
}
