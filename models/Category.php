<?php

namespace app\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Inflector;

/**
 *
 */
class Category extends ActiveRecord
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
        return 'category';
    }

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

    public function beforeSave($insert)
    {
        $this->slug = Inflector::slug($this->name);
        return parent::beforeSave($insert);
    }
}