<?php

namespace app\models;

use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property int $price [int(11)]
 * @property int $price2B [int(11)]
 * @property string $actions
 * @property string $rests
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 * @property string $slug [varchar(255)]
 * @property string $photo [varchar(255)]
 * @property int $category_id [int(11)]
 */
class Product extends ActiveRecord
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
            ]
        ]);
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'product';
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
                    'price',
                    'price2B',
                ],
                'required',
            ],
            [
                [
                    'slug',
                    'actions',
                    'rests',
                    'category_id',
                    'photo',
                    'advanced_photos',
                ],
                'safe'
            ]
        ];
    }
}
