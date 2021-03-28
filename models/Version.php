<?php

namespace app\models;

/**
 * @property string $sys_version [varchar(5)]
 * @property string $mysql_version [varchar(6)]
 * @property int $id [int(11)]
 * @property int $entity_id [int(11)]
 * @property string $entity_class [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Version extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'version';
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
                    'attributes',
                    'created_at',
                ],
                'required'
            ]
        ];
    }
}
