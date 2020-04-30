<?php

namespace app\models;

use kosuha606\VirtualModel\VirtualModel;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Акция для продукта
 * @package kosuha606\Model\iteration2\model
 */
class Action extends ActiveRecord
{
    public static function tableName()
    {
        return 'action';
    }

    public function rules()
    {
        return [
            [
                'productIds',
                'percent',
                'userType',
            ],
            'required',
        ];
    }

    public function getProductIds()
    {
        $result = Json::decode($this->attributes['productIds']);

        return $result;
    }
}