<?php

namespace app\models;

use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property int $id [int(11)]
 * @property string $value [varchar(255)]
 * @property string $type [varchar(255)]
 * @property string $slug [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 * @property int $order [int(11)]
 */
class SeoFilter extends ActiveRecord
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'value',
            ]
        ]);
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'seo_filter';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'type',
                    'value',
                    'order',
                ],
                'required'
            ],
            [
                'slug',
                'safe'
            ]
        ];
    }
}
