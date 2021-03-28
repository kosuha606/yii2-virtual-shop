<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Inflector;

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

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        $this->slug = Inflector::slug($this->value);

        return parent::beforeSave($insert);
    }
}
