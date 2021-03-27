<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class SeoPage extends ActiveRecord
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
        return 'seo_page';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'title',
                    'meta_keywords',
                    'mata_description',
                ],
                'required'
            ],
            [
                [
                    'entity_id',
                    'entity_class',
                    'url',
                    'og_title',
                    'og_description',
                    'og_url',
                    'og_image',
                    'og_type',
                    'canonical',
                    'noindex',
                    'sitemap_importance',
                    'sitemap_freq',
                ],
                'safe'
            ]
        ];
    }
}
