<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Json;

/**
 * @package kosuha606\Model\iteration2\model
 */
class Action extends ActiveRecord
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => new Expression('NOW()'),
            ],
        ];
    }

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
