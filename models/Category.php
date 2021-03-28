<?php

namespace app\models;

use yii\helpers\Inflector;

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

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        $this->slug = Inflector::slug($this->name);

        return parent::beforeSave($insert);
    }
}
