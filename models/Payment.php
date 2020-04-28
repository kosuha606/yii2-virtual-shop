<?php

namespace app\models;

use kosuha606\VirtualModel\VirtualModel;
use yii\db\ActiveRecord;

/**
 * Вариант оплаты
 * @package kosuha606\Model\iteration2\model
 */
class Payment extends ActiveRecord
{
    public static function tableName()
    {
        return 'payment';
    }

    public function rules(): array
    {
        return [
            [
                'comission',
                'description',
                'userType',
            ],
            'required',
        ];
    }
}