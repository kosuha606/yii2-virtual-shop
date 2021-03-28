<?php

namespace app\models;

use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $slug [varchar(255)]
 * @property string $photo [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class Category extends BaseActiveRecord
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
    public static function tableName(): string
    {
        return 'category';
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
                ],
                'required',
            ],
            [
                [
                    'slug',
                    'photo',
                ],
                'safe'
            ]
        ];
    }
}
