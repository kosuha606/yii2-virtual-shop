<?php

namespace app\models;

use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;

/**
 * @property int $id [int(11)]
 * @property string $title [varchar(255)]
 * @property string $slug [varchar(255)]
 * @property string $content
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 * @property string $photo [varchar(255)]
 */
class Article extends BaseActiveRecord
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
            ]
        ]);
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'article';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'slug',
                    'photo',
                ],
                'safe'
            ],
            [
                [
                    'title',
                    'content',
                ],
                'required'
            ]
        ];
    }
}
