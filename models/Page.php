<?php

namespace app\models;

use yii\helpers\Inflector;

/**
 * @property int $id [int(11)]
 * @property string $title [varchar(255)]
 * @property string $slug [varchar(255)]
 * @property string $content
 * @property string $created_at [datetime]
 * @property string $updated_at [datetime]
 * @property bool $is_home [tinyint(1)]
 */
class Page extends BaseActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'page';
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        $this->slug = Inflector::slug($this->title);
        return parent::beforeSave($insert);
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
