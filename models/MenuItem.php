<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property string $link [varchar(255)]
 * @property string $label [varchar(255)]
 * @property int $menu_id [int(11)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 * @property int $order [int(11)]
 */
class MenuItem extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'menu_item';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'link',
                    'label',
                    'order',
                    'menu_id',
                ],
                'required'
            ]
        ];
    }
}
