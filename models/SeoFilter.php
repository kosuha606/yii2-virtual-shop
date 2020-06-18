<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Inflector;

class SeoFilter extends ActiveRecord
{
    public function behaviors()
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

    public static function tableName()
    {
        return 'seo_filter';
    }

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

    public function setSlug()
    {
        $this->slug = '123';
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function beforeSave($insert)
    {
        $this->slug = Inflector::slug($this->value);
        return parent::beforeSave($insert);
    }
}