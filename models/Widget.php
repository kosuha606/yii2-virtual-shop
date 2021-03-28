<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $widget_class [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Widget extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'widget';
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
                    'widget_class',
                ],
                'required'
            ]
        ];
    }
}
