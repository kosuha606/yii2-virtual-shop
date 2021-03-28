<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property int $article_id [int(11)]
 * @property string $meta_title [varchar(255)]
 * @property string $meta_keywords [varchar(255)]
 * @property string $meta_description [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class SeoArticle extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'seo_article';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'article_id',
                ],
                'required'
            ],
            [
                [
                    'meta_title',
                    'meta_keywords',
                    'meta_description',
                ],
                'safe'
            ]
        ];
    }
}
