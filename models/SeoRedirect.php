<?php

namespace app\models;

/**
 * @property int $id [int(11)]
 * @property string $from_url [varchar(255)]
 * @property string $to_url [varchar(255)]
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 */
class SeoRedirect extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'seo_redirect';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                [
                    'from_url',
                    'to_url',
                ],
                'required'
            ],
        ];
    }
}
