<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $entity_id [int(11)]
 * @property string $entity_class [varchar(255)]
 * @property string $url [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class SeoUrl extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'seo_url';
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
                    'url',
                ],
                'required'
            ],
        ];
    }
}
