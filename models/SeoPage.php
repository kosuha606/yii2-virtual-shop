<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property int $entity_id [int(11)]
 * @property string $entity_class [varchar(255)]
 * @property string $title [varchar(255)]
 * @property string $meta_keywords [varchar(255)]
 * @property string $mata_description [varchar(255)]
 * @property string $og_title [varchar(255)]
 * @property string $og_description [varchar(255)]
 * @property string $og_url [varchar(255)]
 * @property string $og_image [varchar(255)]
 * @property string $og_type [varchar(255)]
 * @property string $canonical [varchar(255)]
 * @property string $noindex [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 * @property string $sitemap_importance [varchar(255)]
 * @property string $sitemap_freq [varchar(255)]
 * @property string $url [varchar(255)]
 */
class SeoPage extends BaseActiveRecord
{
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
