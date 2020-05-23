<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class SeoArticle extends ActiveRecord
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
        return 'seo_article';
    }

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