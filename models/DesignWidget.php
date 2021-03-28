<?php

namespace app\models;

/**
 * @property $design_id
 * @property int $id [int(11)]
 * @property int $widget_id [int(11)]
 * @property string $position [varchar(255)]
 * @property int $order [int(11)]
 * @property string $config [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class DesignWidget extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'design_widget';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'design_id',
                    'widget_id',
                    'position',
                    'order',
                    'config',
                ],
                'required'
            ]
        ];
    }
}
