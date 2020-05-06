<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Json;

class FilterCategory extends ActiveRecord
{
    public static function tableName()
    {
        return 'filter_category';
    }

    public function rules()
    {
        return [
            [
                'name',
            ],
            'required',
        ];
    }
}