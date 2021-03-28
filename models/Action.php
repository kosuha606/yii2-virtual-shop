<?php

namespace app\models;

use yii\helpers\Json;

/**
 * @property-read null|array $productIds
 * @property int $id [int(11)]
 * @property int $percent [int(11)]
 * @property string $userType [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Action extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'action';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'productIds',
                    'percent',
                    'userType',
                ],
                'required',
            ]
        ];
    }

    /**
     * @return array|null
     */
    public function getProductIds(): ?array
    {
        return Json::decode($this->attributes['productIds'], true);
    }
}
