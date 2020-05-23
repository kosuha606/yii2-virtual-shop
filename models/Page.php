<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Inflector;

class Page extends ActiveRecord
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
        return 'page';
    }

    public function beforeSave($insert)
    {
        $this->slug = Inflector::slug($this->title);
        return parent::beforeSave($insert);
    }

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