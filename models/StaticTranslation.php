<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $value [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class StaticTranslation extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'static_translation';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'value',
                ],
                'required'
            ]
        ];
    }
}
