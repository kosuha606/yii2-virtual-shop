<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property int $user_id [int(11)]
 * @property string $entity_id [varchar(255)]
 * @property string $entity_class [varchar(255)]
 * @property string $form_data
 * @property string $form_config
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class AdminVersion extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'admin_version';
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
